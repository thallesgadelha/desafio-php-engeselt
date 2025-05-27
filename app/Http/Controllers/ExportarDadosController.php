<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Exports\ChamadosExport;

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

    public function exportarExcel(Request $request): BinaryFileResponse
    {
        $query = Chamado::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        $chamados = $query->get();

        return Excel::download(new ChamadosExport($chamados), 'chamados.xlsx');
    }
}
