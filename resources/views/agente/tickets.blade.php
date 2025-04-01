@extends('layouts.app')

@section('title', 'Tickets Asignados')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tickets Asignados</h2>
    </div>

    {{-- Filtros --}}
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="">Todos</option>
                <option value="Abierto" {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="En proceso" {{ request('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="Resuelto" {{ request('estado') == 'Resuelto' ? 'selected' : '' }}>Resuelto</option>
                <option value="Cerrado" {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select name="prioridad" class="form-select">
                <option value="">Todas</option>
                <option value="Baja" {{ request('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                <option value="Media" {{ request('prioridad') == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Alta" {{ request('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                <option value="Urgente" {{ request('prioridad') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" class="form-select">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ request('categoria_id') == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="desde" class="form-label">Desde</label>
            <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
        </div>

        <div class="col-md-3">
            <label for="hasta" class="form-label">Hasta</label>
            <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
        </div>

        <div class="col-md-12 text-end">
            <button class="btn btn-lima" type="submit">
                <i class="bi bi-funnel-fill"></i> Filtrar
            </button>
        </div>
    </form>

    {{-- Tabla --}}
    <div class="bg-white rounded shadow-sm border p-4">
        <h5 class="mb-3 fw-bold">Lista de Tickets</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID Ticket</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
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
                            <td>{{ $ticket->cliente->nombre }} {{ $ticket->cliente->apellido }}</td>
                            <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $ticket->prioridad }}</span></td>
                            <td><span class="badge bg-success">{{ $ticket->estado }}</span></td>
                            <td>
                                <a href="{{ route('agente.tickets.show', $ticket->id_ticket) }}"
                                   class="btn btn-sm btn-lima rounded-circle">
                                    <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay tickets asignados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
