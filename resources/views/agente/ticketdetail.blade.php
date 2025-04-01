@extends('layouts.app')

@section('title', 'Detalle de Ticket')

@section('content')
<div class="container py-4">
    <a href="{{ route('agente.tickets') }}" class="btn btn-lima mb-3">
        <i class="bi bi-arrow-left-circle me-1"></i> Regresar
    </a>

    <h2 class="fw-bold mb-4">Detalle Ticket #{{ $ticket->id_ticket }}</h2>

    {{-- Info general --}}
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
                   value="{{ $ticket->agente ? $ticket->agente->nombre . ' ' . $ticket->agente->apellido : 'No asignado' }}"
                   disabled>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="mb-4">
        <label class="form-label fw-bold">Descripción</label>
        <textarea class="form-control" rows="2" disabled>{{ $ticket->descripcion }}</textarea>
    </div>

    {{-- Comentarios --}}
    <div class="mb-4">
        <h5 class="fw-bold">Comentarios</h5>
        <form method="POST" action="{{ route('agente.tickets.comentar', $ticket->id_ticket) }}" class="d-flex align-items-center mb-3">
            @csrf
            <input type="text" name="contenido" class="form-control me-2" placeholder="Agrega un comentario" required>
            <button type="submit" class="btn btn-outline-dark">
                <i class="bi bi-save fs-5"></i>
            </button>
        </form>

        @forelse ($ticket->comentarios as $comentario)
            <div class="mb-3 border-bottom pb-2">
                <p>{{ $comentario->contenido }}</p>
                <small class="text-muted">{{ $comentario->created_at->format('d/m/Y h:i a') }}</small>
            </div>
        @empty
            <p class="text-muted">Aún no se han realizado comentarios.</p>
        @endforelse
    </div>

    {{-- Cambiar estado --}}
    <div class="mb-5">
        <h5 class="fw-bold">Historial de Estados</h5>

        @if ($ticket->estado === 'Cerrado')
            <div class="alert alert-warning">
                Este ticket está cerrado y no se puede cambiar de estado.
            </div>
        @else
            <form method="POST" action="{{ route('agente.tickets.estado', $ticket->id_ticket) }}" id="estadoForm">
                @csrf
                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label for="nuevo_estado" class="form-label">Estado Actual</label>

                        @php
                            $todosEstados = ['Abierto', 'En proceso', 'Resuelto', 'Cerrado'];
                            $usados = $ticket->historialEstados->pluck('estado')->toArray();
                            $disponibles = array_diff($todosEstados, $usados);

                            if ($ticket->estado === 'Resuelto') {
                                $disponibles = array_diff($disponibles, ['Cerrado']);
                            }
                        @endphp

                        <select name="nuevo_estado" id="nuevo_estado" class="form-select" required>
                            <option value="">Seleccionar nuevo estado</option>
                            @foreach ($disponibles as $estado)
                                <option value="{{ $estado }}">{{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-lima w-100">Actualizar</button>
                    </div>
                </div>
            </form>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Cambios de estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ticket->historialEstados->sortBy('created_at') as $estado)
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

@push('scripts')
@if ($ticket->estado !== 'Cerrado')
<script>
    document.getElementById('estadoForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const estado = document.getElementById('nuevo_estado').value;

        if (!estado) return;

        let mensaje = 'Una vez actualizado, no podrás volver a este estado.';
        let icon = 'warning';

        if (estado === 'Cerrado') {
            mensaje = 'Este ticket será cerrado sin resolverse. ¿Deseas continuar?';
            icon = 'error';
        }

        Swal.fire({
            icon: icon,
            title: '¿Cambiar estado?',
            text: mensaje,
            showCancelButton: true,
            confirmButtonColor: '#baf266',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cambiar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@endif
@endpush
