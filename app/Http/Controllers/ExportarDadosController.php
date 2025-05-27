<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportarDadosController extends Controller
{
    public function exportarPdf(Request $request)
    {
        $query = Chamado::query();

        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        if ($request->has('prioridade') && $request->prioridade !== null) {
            $query->where('prioridade', $request->prioridade);
        }

        $chamados = $query->get();

        $pdf = Pdf::loadView('exports.chamados', compact('chamados'));

        return $pdf->stream('chamados.pdf');
    }
}
