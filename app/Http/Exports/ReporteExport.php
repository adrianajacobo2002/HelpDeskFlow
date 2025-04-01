<?php
namespace App\Exports;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class ReporteExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $inicio = $this->request->input('inicio') ?? now()->subDays(30);
        $fin = $this->request->input('fin') ?? now();

        $tickets = Ticket::whereBetween('created_at', [$inicio, $fin])->get();
        $porEstado = $tickets->groupBy('estado')->map->count();
        $porCategoria = $tickets->groupBy('id_categoria')->map->count();
        $categorias = Categoria::pluck('nombre', 'id_categoria');
        $porAgente = $tickets->whereNotNull('id_agente')->groupBy('id_agente')->map->count();
        $agentes = User::where('rol', 'agente')->pluck('nombre', 'id');

        return view('admin.reporte_excel', compact('porEstado', 'porCategoria', 'porAgente', 'categorias', 'agentes'));
    }
}
