<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Categoria;

class ClienteController extends Controller
{

    public function dashboard()
    {
        $userId = Auth::id();

        $categorias = Categoria::all();

        
        $total = Ticket::where('id_usuario', $userId)->count();
        $abiertos = Ticket::where('id_usuario', $userId)->where('estado', 'Abierto')->count();
        $en_proceso = Ticket::where('id_usuario', $userId)->where('estado', 'En proceso')->count();
        $resueltos = Ticket::where('id_usuario', $userId)->where('estado', 'Resuelto')->count();
        $cerrados = Ticket::where('id_usuario', $userId)->where('estado', 'Cerrado')->count();

        
        $tickets = Ticket::with(['agente', 'categoria'])
            ->where('id_usuario', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('cliente.dashboard', compact(
            'tickets',
            'total',
            'abiertos',
            'en_proceso',
            'resueltos',
            'cerrados',
            'categorias'
        ));
    }

    
}
