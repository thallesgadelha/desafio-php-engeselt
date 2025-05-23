<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
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
}