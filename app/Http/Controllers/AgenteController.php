<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Categoria;

class AgenteController extends Controller
{

    public function dashboard()
    {
        $agenteId = Auth::id();

        
        $tickets = Ticket::with(['cliente', 'categoria'])
            ->where('id_agente', $agenteId)
            ->latest()
            ->take(5)
            ->get();

        
        $total = Ticket::where('id_agente', $agenteId)->count();
        $abiertos = Ticket::where('id_agente', $agenteId)->where('estado', 'Abierto')->count();
        $en_proceso = Ticket::where('id_agente', $agenteId)->where('estado', 'En proceso')->count();
        $resueltos = Ticket::where('id_agente', $agenteId)->where('estado', 'Resuelto')->count();
        $cerrados = Ticket::where('id_agente', $agenteId)->where('estado', 'Cerrado')->count();

        return view('agente.dashboard', compact(
            'tickets',
            'total',
            'abiertos',
            'en_proceso',
            'resueltos',
            'cerrados'
        ));
    }

    public function misTickets(Request $request)
    {
        $agenteId = Auth::id();

        $query = Ticket::with(['cliente', 'categoria'])
            ->where('id_agente', $agenteId);

        // Aplicar filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('categoria_id')) {
            $query->where('id_categoria', $request->categoria_id);
        }

        if ($request->filled('desde')) {
            $query->whereDate('created_at', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('created_at', '<=', $request->hasta);
        }

        $tickets = $query->latest()->get();
        $categorias = Categoria::all();

        return view('agente.tickets', compact('tickets', 'categorias'));
    }

    
}
