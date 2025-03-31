<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Categoria;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Ver listado de tickets del cliente
    public function index()
    {
        $tickets = Ticket::with(['categoria', 'agente'])
            ->where('id_usuario', Auth::id())
            ->latest()
            ->get();

        return view('cliente.tickets.index', compact('tickets'));
    }

    // Mostrar formulario para crear ticket
    public function create()
    {
        $categorias = Categoria::all();
        return view('cliente.tickets.create', compact('categorias'));
    }

    // Guardar nuevo ticket
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:Baja,Media,Alta,Urgente',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $ticket = Ticket::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'estado' => 'Abierto',
            'id_usuario' => Auth::id(),
            'categoria_id' => $request->categoria_id,
            'fecha_creacion' => now(),
        ]);

        // Registrar primer historial de estado
        HistorialEstado::create([
            'ticket_id' => $ticket->id,
            'usuario_id' => Auth::id(),
            'estado_anterior' => null,
            'estado_nuevo' => 'Abierto',
            'fecha_cambio' => now(),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    // Ver detalles de un ticket
    public function show(Ticket $ticket)
    {
        // Solo mostrar si pertenece al usuario autenticado
        if ($ticket->id_usuario !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['categoria', 'agente', 'comentarios']);

        return view('cliente.tickets.show', compact('ticket'));
    }
}
