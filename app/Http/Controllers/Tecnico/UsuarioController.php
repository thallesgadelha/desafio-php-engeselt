<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlterarPermissaoRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();

        return Inertia::render('Tecnico/Usuarios/Index', compact('usuarios'));
    }

    public function alterarPermissao(AlterarPermissaoRequest $request, User $user)
    {
        $user->update([
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('tecnico.usuarios.index')->with('success', 'Permissão e Status Alterados.');
    }
}