<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CategoriaController extends Controller
{
    public function index()
    {   
        $categorias = Categoria::all();

        return Inertia::render('Categorias/Index', compact('categorias'));
    }

    public function store(StoreCategoriaRequest $request)
    {
        $data = $request->validated();

        Categoria::create($data);

        return redirect()->route('categorias.index')->with('success', 'Categoria criado com sucesso.');
    }

    public function update(StoreCategoriaRequest $request, Categoria $categoria)
    {
        $data = $request->validated();
        $categoria->update($data);

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function delete(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria deletada com sucesso.');
    }
}
