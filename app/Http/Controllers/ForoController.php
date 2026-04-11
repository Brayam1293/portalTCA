<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tema;
use Illuminate\Support\Facades\Auth;
use App\Models\Foro;
use App\Models\Like;
use App\Models\Comentario;

class ForoController extends Controller
{
    public function index()
    {
        $temas = Tema::with(['user', 'comentarios.usuario', 'likes'])
            ->where('visible', 1)
            ->get();

        return view('foro.foro', compact('temas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'message' => 'required|min:10',
            'categoria' => 'required'
        ]);

        Tema::create([
            'titulo' => $request->title,
            'mensaje' => $request->message,
            'categoria' => $request->categoria,
            'id_usuario' => auth()->id()
        ]);

        return redirect()->back();
    }

    public function like($id)
    {
        $userId = auth()->id();

        $like = Like::where('id_usuario', $userId)
            ->where('id_foro', $id)
            ->first();

        if ($like) {
            $like->delete();
            $status = 'removed';
        } else {
            Like::create([
                'id_usuario' => $userId,
                'id_foro' => $id
            ]);
            $status = 'added';
        }

        $total = Like::where('id_foro', $id)->count();

        return response()->json([
            'status' => $status,
            'total' => $total
        ]);
    }

    public function comentar(Request $request, $id)
    {
        Comentario::create([
            'id_usuario' => auth()->id(),
            'id_foro' => $id,
            'comentario' => $request->comentario
        ]);

        return back();
    }

    // Ocultar temas
    public function eliminar($id)
    {
        $foro = Foro::findOrFail($id);

        $user = auth()->user();

        if ($user->tipo_usuario == 1 || $foro->id_usuario == $user->id) {
            $foro->visible = 0;
            $foro->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }
}