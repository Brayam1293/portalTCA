<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Foro;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function validarAdmin()
    {
        if (!auth()->check() || auth()->user()->tipo_usuario != 1) {
            abort(403, 'Acceso denegado');
        }
    }

    public function dashboard(Request $request)
    {
        $this->validarAdmin();

        $query = User::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {

                $q->where('id', 'like', "%$buscar%")
                ->orWhere('usuario', 'like', "%$buscar%");

                if (strtolower($buscar) == 'admin') {
                    $q->orWhere('tipo_usuario', 1);
                }

                if (strtolower($buscar) == 'basico') {
                    $q->orWhere('tipo_usuario', 2);
                }

                if (strtolower($buscar) == 'activo') {
                    $q->orWhere('activo', 1);
                }

                if (strtolower($buscar) == 'desactivado') {
                    $q->orWhere('activo', 0);
                }
            });
        }

        $usuarios = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return view('admin.dashboard', compact('usuarios'));
    }

    public function update(Request $request, $id)
    {
        $this->validarAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'usuario' => 'required|email|unique:users,usuario,' . $id,
        ]);
        $user->tipo_usuario = $request->tipo_usuario;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back();
    }

    public function delete($id)
    {
        $this->validarAdmin();

        $user = User::find($id);

        if($user){
            $user->activo = 0;
            $user->save();
        }

        return back();
    }

    public function view($id)
    {
        $this->validarAdmin();

        $usuario = User::findOrFail($id);

        $temas = Foro::where('id_usuario', $id)->get();

        return view('admin.user-view', compact('usuario', 'temas'));
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'usuario' => 'required|email|unique:users,usuario',
            'password' => 'required|min:6',
            'tipo_usuario' => 'required',
            'activo' => 'required'
        ]);

        User::create([
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password),
            'tipo_usuario' => $request->tipo_usuario,
            'activo' => $request->activo,
            'is_verified' => 1
        ]);

        return redirect('/admin');
    }
}