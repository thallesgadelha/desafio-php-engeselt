<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CategoriaController extends Controller
{
    public function index()
    {   
        $categorias = Categoria::all();

        return Inertia::render('Tecnico/Categorias/Index', compact('categorias'));
    }

    public function store()
    {

    }
}
