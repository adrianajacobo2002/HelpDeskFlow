@extends('layouts.app')

@section('title', 'Mis Tickets')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Mis Tickets</h2>
            <button class="btn btn-lima" data-bs-toggle="modal" data-bs-target="#crearTicketModal">
                <i class="bi bi-plus-circle text-dark"></i> Crear nuevo ticket
            </button>
        </div>

        <div class="bg-white rounded shadow-sm border p-4">
            <h5 class="mb-3 fw-bold">Lista de Tickets</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID Ticket</th>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Agente</th>
                            <th>Categoría</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id_ticket }}</td>
                                <td>{{ $ticket->titulo }}</td>
                                <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ optional($ticket->agente)->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $ticket->prioridad }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $ticket->estado }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('tickets.show', ['ticket' => $ticket->id_ticket]) }}"
                                       class="btn btn-sm btn-lima rounded-circle">
                                        <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No hay tickets registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
