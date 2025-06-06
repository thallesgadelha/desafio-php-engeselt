<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChamadoRequest;
use App\Models\Chamado;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        $query = Chamado::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        $chamados = $query->latest()->get();

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

        return redirect()->route('chamados.index')->with('toast', 'Chamado criado com sucesso.');
    }

    public function show(Chamado $chamado)
    {
        $chamado = Chamado::with(['respostas.user'])
            ->select('chamados.*', 'users.name as nome_usuario')
            ->leftJoin('users', 'chamados.user_id', '=', 'users.id')
            ->where('chamados.id', $chamado->id)
            ->first();

        return Inertia::render('Chamados/Show', [
            'chamado' => $chamado,
            'respostas' => $chamado->respostas,
        ]);
    }
}

