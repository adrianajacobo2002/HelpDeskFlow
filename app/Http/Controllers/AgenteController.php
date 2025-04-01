<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

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
    
}
