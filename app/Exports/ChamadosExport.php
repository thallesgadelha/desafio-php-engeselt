<?php

namespace App\Exports;

use App\Models\Chamado;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ChamadosExport implements FromView
{
    protected $chamados;

    public function __construct(Collection $chamados)
    {
        $this->chamados = $chamados;
    }

    public function view(): View
    {
        return view('exports.chamados_excel', [
            'chamados' => $this->chamados
        ]);
    }
}