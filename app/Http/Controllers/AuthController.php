<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Autentica al usuario con usuario y contraseña
        $user = User::where('usuario', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Obtiene el usuario autenticado
            $user = User::where('usuario', $request->email)->first();

            // Genera la OTP de 6 dígitos
            $otp = rand(100000, 999999);

            // Guarda OTP y tiempo de expiración
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            // Guardar usuario temporal en sesión
            session([
                'otp_user_id' => $user->id
            ]);

            session()->save();

            try {
                // Envía el OTP al correo
                Mail::raw("Tu código de verificación es: $otp", function ($message) use ($request) {
                    $message->to($request->email)
                            ->subject('Código de verificación');
                });
            } catch (\Exception $e) {
                // Manejo de error si falla el envío de correo
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

        // Credenciales incorrectas
        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
    }

    // Validar la OTP
    public function verifyOtp(Request $request)
    {
        \Log::info(session()->all());

        // Validación básica de datos
        if (!$request->email || !$request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Datos incompletos'
            ]);
        }

        // Busca usuario por correo
        $user = User::where('usuario', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        // Comparación del OTP
        if ((string)$user->otp === trim($request->otp)) {

            // Verifica si el OTP expiró
            if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El código expiró'
                ]);
            }

            Auth::login($user);

            // limpiar OTP
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            return response()->json([
                'success' => true
            ]);
        }

        // OTP incorrecto
        return response()->json([
            'success' => false,
            'message' => 'Código incorrecto'
        ]);
    }

    // reenviar codigo
    public function resendOtp(Request $request)
    {
        // Buscar usuario
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
            // Envia nuevo codigo
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

    public function showForgot()
    {
        // Solo limpiar si NO viene de OTP verificado
        if (!session('otp_verified')) {
            session()->forget(['reset_user_id', 'reset_email']);
        }

        return view('forget_password');
    }

    // Enviar OTP para cambiar contraseña
    public function sendOtp(Request $request)
    {
        $request->validate([
            'usuario' => 'required|email'
        ]);

        // Buscar usuario
        $user = User::where('usuario', $request->usuario)->first();

        if (!$user) {
            return back()->with('error', 'El correo no existe');
        }

        // Generar OTP aleatorio
        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // Guardar sesión
        session([
            'reset_user_id' => $user->id,
            'reset_email' => $user->usuario,
            'otp_verified' => false
        ]);
        session()->save();

        // Enviar correo
        Mail::raw("Tu código OTP es: $otp", function ($message) use ($request) {
            $message->to($request->usuario)
                    ->subject('Recuperación de contraseña');
        });

        return redirect('/otp')->with('flow', 'reset');
    }

    // Validar OTP
    public function verifyOtpReset(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $userId = session('reset_user_id');

        // Validar sesion
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Sesión expirada'
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        // Comparacion OTP
        if ((string)$user->otp !== trim((string)$request->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP incorrecto'
            ]);
        }

        // Validar expiración de OTP
        if (now()->gt($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expirado'
            ]);
        }

        // Marcar como verificado
        session(['otp_verified' => true]);

        session()->save();

        return response()->json([
            'success' => true
        ]);
    }

    // Cambiar contraseña en BD
    public function resetPassword(Request $request)
    {
        // Mensajes para validar la informacion de los campos
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ], [
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'Debe contener minimo 6 caracteres',
            'password.confirmed' => 'Deben ser iguales'
        ]);

        $user = User::find(session('reset_user_id'));

        // Validar sesión y OTP
        if (!$user || !session('otp_verified')) {
            return redirect('/forgot-password')->with('error', 'Proceso inválido');
        }

        // Cambiar solo al usuario selecionado
        $user->password = Hash::make($request->password);
        // Limpia la OTP
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Limpiar sesión
        session()->forget(['reset_user_id', 'otp_verified']);

        return redirect('/login')->with('success', 'Contraseña actualizada');
    }

    public function showRegister()
    {
        return view('registro');
    }

    public function register(Request $request)
    {
        $request->validate([
            'usuario' => 'required|email|unique:users,usuario',
            'password' => 'required|min:6'
        ]);

        $otp = rand(100000, 999999);

        // Guardar usuario directamente en BD
        $user = User::create([
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
            'is_verified' => 0
        ]);

        // Enviar OTP
        try {
            Mail::raw("Tu código OTP es: $otp", function ($message) use ($request) {
                $message->to($request->usuario)
                        ->subject('Registro de cuenta');
            });
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al enviar correo: ' . $e->getMessage()
            ]);
        }

        return redirect('/otp')->with('flow', 'register');
    }

    public function verifyOtpRegister(Request $request)
    {
        if (!$request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email no recibido'
            ]);
        }

        $request->validate([
            'otp' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::where('usuario', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        if ((string)$user->otp !== trim((string)$request->otp)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP incorrecto'
            ]);
        }

        if (now()->gt($user->otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expirado'
            ]);
        }

        // ✅ Verificar usuario
        $user->is_verified = 1;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function resendOtpRegister(Request $request)
    {
        $user = User::where('usuario', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ]);
        }

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        Mail::raw("Tu nuevo código es: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Nuevo código de registro');
        });

        return response()->json([
            'success' => true
        ]);
    }

    // Cerrar Sesion
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
