<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChamadoTecnicoController extends Controller
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

        return Inertia::render('Tecnico/Chamados/Index', compact('chamados'));
    }

    public function show(Chamado $chamado)
    {
        $chamado = Chamado::with(['respostas.user'])
            ->select('chamados.*', 'users.name as nome_usuario')
            ->leftJoin('users', 'chamados.user_id', '=', 'users.id')
            ->where('chamados.id', $chamado->id)
            ->first();

        return Inertia::render('Tecnico/Chamados/Show', [
            'chamado' => $chamado,
            'respostas' => $chamado->respostas,
        ]);
    }

    public function responder(Request $request, Chamado $chamado)
    {
        $request->validate([
            'mensagem' => 'required|string',
        ]);

        $chamado->respostas()->create([
            'user_id' => auth()->id(),
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('tecnico.chamados.show', $chamado->id)->with('success', 'Resposta enviada.');
    }

    public function alterarStatus(Request $request, Chamado $chamado)
    {
        $request->validate([
            'status' => 'required|in:Aberto,Em atendimento,Resolvido,Fechado',
        ]);

        $chamado->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status atualizado.');
    }
}

