<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class ClienteController extends Controller
{

    public function dashboard()
    {
        $userId = Auth::id();

        $tickets = Ticket::with(['agente', 'categoria'])
            ->where('id_usuario', $userId)
            ->latest()
            ->take(5)
            ->get();

        $total = $tickets->count();
        $resueltos = $tickets->where('estado', 'Resuelto')->count();
        $en_proceso = $tickets->where('estado', 'En proceso')->count();
        $en_espera = $tickets->where('estado', 'En Espera')->count();

        return view('cliente.dashboard', compact('tickets', 'total', 'resueltos', 'en_proceso', 'en_espera'));
    }
    
}
