<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'usuario' => $request->email,
            'password' => $request->password
        ])) {
            $user = User::where('usuario', $request->email)->first();

            
            $otp = rand(100000, 999999);

            
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            try {
                Mail::raw("Tu código de verificación es: $otp", function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Código de verificación');
                });
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al enviar correo: ' . $e->getMessage()
                ]);
            }

            return response()->json([
                'success' => true,
                'email' => $request->email
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
    }

    public function verifyOtp(Request $request)
    {
        if (!$request->email || !$request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
        }

        $user = User::where('usuario', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        if ((string)$user->otp === trim($request->otp)) {

            if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código expiró'
                ]);
            }

            // limpiar OTP
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Código incorrecto'
        ]);
    }

    // reenviar codigo
    public function resendOtp(Request $request)
    {
        $user = User::where('usuario', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        // generar nuevo código
        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        try {
            Mail::raw("Tu nuevo código es: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Nuevo código de verificación');
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar correo'
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
