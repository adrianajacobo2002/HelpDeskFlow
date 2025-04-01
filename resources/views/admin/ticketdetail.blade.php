@extends('layouts.app')

@section('title', 'Detalle de Ticket')

@section('content')
    <div class="container py-4">
        <a href="{{ route('admin.tickets.index') }}" class="btn btn-lima mb-3">
            <i class="bi bi-arrow-left-circle me-1"></i> Regresar
        </a>

        <h2 class="fw-bold mb-4">Detalle Ticket #{{ $ticket->id_ticket }}</h2>

        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">Título de Problemática</label>
                <input type="text" class="form-control" value="{{ $ticket->titulo }}" disabled>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Prioridad</label>
                <input type="text" class="form-control" value="{{ $ticket->prioridad }}" disabled>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Categoría</label>
                <input type="text" class="form-control" value="{{ $ticket->categoria->nombre ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Agente Asignado</label>
                <input type="text" class="form-control"
                    value="{{ $ticket->agente ? $ticket->agente->nombre . ' ' . $ticket->agente->apellido : 'No asignado' }}" disabled>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Descripción</label>
            <textarea class="form-control" rows="2" disabled>{{ $ticket->descripcion }}</textarea>
        </div>

        <div class="mb-5">
            <h5 class="fw-bold">Comentarios</h5>
            @if ($ticket->comentarios->isEmpty())
                <p class="text-muted">Aún no se han realizado comentarios.</p>
            @else
                @foreach ($ticket->comentarios as $comentario)
                    <div class="mb-3 border-bottom pb-2">
                        <p>{{ $comentario->contenido }}</p>
                        <small class="text-muted">{{ $comentario->created_at->format('d/m/Y h:i a') }}</small>
                    </div>
                @endforeach
            @endif
        </div>

        <div>
            <h5 class="fw-bold">Historial de Estados</h5>
            @php
                $historial = $ticket->historialEstados->sortBy('created_at');
            @endphp
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Cambios de Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($historial as $estado)
                        <tr>
                            <td>{{ $estado->estado }}</td>
                            <td>{{ $estado->created_at->format('d/m/Y h:i a') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2">No hay historial registrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
