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

    public function show(Ticket $ticket)
    {
        if ($ticket->id_agente !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['agente', 'categoria', 'comentarios', 'historialEstados']);
        return view('agente.ticketdetail', compact('ticket'));
    }

    public function actualizarEstado(Request $request, Ticket $ticket)
    {
        if ($ticket->id_agente !== Auth::id()) {
            abort(403);
        }

        $request->validate(['nuevo_estado' => 'required']);
        $nuevoEstado = $request->nuevo_estado;
        $estadoActual = $ticket->estado;

        
        if ($nuevoEstado === $estadoActual) {
            return redirect()->back()->with('error', 'Este estado ya está asignado.');
        }

        
        if ($estadoActual === 'Resuelto' && $nuevoEstado === 'Cerrado') {
            return redirect()->back()->with('error', 'No se puede cambiar de "Resuelto" a "Cerrado".');
        }

        
        $ticket->estado = $nuevoEstado;

        
        if ($nuevoEstado === 'Resuelto') {
            $ticket->fecha_resolucion = now();
        }

        $ticket->save();

        
        $ticket->historialEstados()->create([
            'estado' => $nuevoEstado,
            'fecha' => now(),
        ]);

        
        if ($nuevoEstado === 'Cerrado') {
            $ticket->comentarios()->create([
                'contenido' => "Ticket cerrado sin resolución. Estado final: Cerrado. [". now()->format('d/m/Y h:i a') ."]",
                'id_usuario' => Auth::id(),
            ]);
        } else {
            $ticket->comentarios()->create([
                'contenido' => "Estado actualizado a $nuevoEstado el " . now()->format('d/m/Y h:i a'),
                'id_usuario' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('success', 'Estado actualizado correctamente.');
    }

    public function comentar(Request $request, Ticket $ticket)
    {
        if ($ticket->id_agente !== Auth::id()) abort(403);

        $request->validate(['contenido' => 'required|string']);

        $ticket->comentarios()->create([
            'contenido' => $request->contenido,
            'id_usuario' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Comentario agregado.');
    }


    
}
