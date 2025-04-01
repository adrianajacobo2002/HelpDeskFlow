<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de tiempo
        $inicio = $request->input('inicio') ? Carbon::parse($request->input('inicio')) : now()->subDays(30);
        $fin = $request->input('fin') ? Carbon::parse($request->input('fin')) : now();

        $tickets = Ticket::whereBetween('created_at', [$inicio, $fin])->get();

        $porEstado = $tickets->groupBy('estado')->map->count();
        $porCategoria = $tickets->groupBy('id_categoria')->map->count();
        $categorias = Categoria::pluck('nombre', 'id_categoria');
        $porAgente = $tickets->whereNotNull('id_agente')->groupBy('id_agente')->map->count();
        $agentes = User::where('rol', 'agente')->pluck('nombre', 'id');

        return view('admin.reportes', compact('porEstado', 'porCategoria', 'porAgente', 'categorias', 'agentes', 'inicio', 'fin'));
    }

    public function exportarExcel(Request $request)
    {
        return Excel::download(new ReporteExport($request), 'reporte.xlsx');
    }

    public function exportarPDF(Request $request)
    {
        $porEstado = Ticket::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $porCategoria = Categoria::withCount('tickets')->get()->pluck('tickets_count', 'nombre');

        $porAgente = User::where('rol', 'agente')
            ->withCount(['ticketsAsignados as atendidos' => function ($query) {
                $query->whereNotNull('id_agente');
            }])
            ->get()
            ->pluck('atendidos', 'nombre');

        $pdf = PDF::loadView('admin.reporte_pdf', [
            'porEstado' => $porEstado,
            'porCategoria' => $porCategoria,
            'porAgente' => $porAgente
        ]);

        return $pdf->download('reporte.pdf');
    }
}
