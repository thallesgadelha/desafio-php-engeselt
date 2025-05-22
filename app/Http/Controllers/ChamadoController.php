<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChamadoRequest;
use App\Models\Chamado;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChamadoController extends Controller
{
    public function index()
    {
        $chamados = auth()->user()->chamados()->latest()->get();

        return Inertia::render('Chamados/Index', compact('chamados'));
    }

    public function create()
    {
        $categorias = Categoria::all();

        return Inertia::render('Chamados/Create', compact('categorias'));
    }

    public function store(StoreChamadoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('anexo')) {
            $data['anexo'] = $request->file('anexo')->store('anexos', 'public');
        }

        $request->user()->chamados()->create($data);

        return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso.');
    }

    public function show(Chamado $chamado)
    {
        $chamado = Chamado::select('chamados.*', 'users.name as nome_usuario')
            ->leftJoin('users', 'chamados.user_id', '=', 'users.id')
            ->where('chamados.id', $chamado->id)
            ->first();

        return Inertia::render('Chamados/Show', compact('chamado'));
    }
}

