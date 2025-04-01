<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Categoria;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        Log::info('Método store ejecutado', $request->all());

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:Baja,Media,Alta,Urgente',
            'categoria_id' => 'required|exists:categorias,id_categoria',
        ]);

        $ticket = Ticket::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'estado' => 'Abierto',
            'id_usuario' => Auth::id(),
            'id_categoria' => $request->categoria_id,
            'fecha_creacion' => now(),
        ]);

        // Registrar primer historial de estado
        HistorialEstado::create([
            'id_ticket' => $ticket->id_ticket,
            'usuario_id' => Auth::id(),
            'estado' => 'Abierto',
            'fecha_cambio' => now(),
        ]);

        return redirect()->route('cliente.dashboard')->with('success', '¡Ticket creado con éxito!');
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
    // Admin dashboard (estadísticas globales)
    public function estadisticasGlobales()
    {
        $total = Ticket::count();
        $abiertos = Ticket::where('estado', 'Abierto')->count();
        $en_proceso = Ticket::where('estado', 'En proceso')->count();
        $resueltos = Ticket::where('estado', 'Resuelto')->count();
        $cerrados = Ticket::where('estado', 'Cerrado')->count();

        $tickets = Ticket::select(
                'tickets.*',
                'clientes.nombre as cliente_nombre',
                'clientes.apellido as cliente_apellido',
                'categorias.nombre as categoria_nombre'
            )
            ->leftJoin('users as clientes', 'tickets.id_usuario', '=', 'clientes.id')
            ->leftJoin('categorias', 'tickets.id_categoria', '=', 'categorias.id_categoria')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'total',
            'abiertos',
            'en_proceso',
            'resueltos',
            'cerrados',
            'tickets'
        ));
    }
    // Ver ticket desde vista del admin (sin restricción de dueño)
    public function showDesdeAdmin(Ticket $ticket)
    {
        $ticket->load(['categoria', 'agente', 'comentarios']);
        return view('admin.tickets.show', compact('ticket'));
    }

}
