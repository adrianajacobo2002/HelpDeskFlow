@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
    <div class="container py-4">
        <h2 class="fw-bold mb-4">Tickets</h2>

        {{-- Filtros --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="Abierto" {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                    <option value="En proceso" {{ request('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                    <option value="Resuelto" {{ request('estado') == 'Resuelto' ? 'selected' : '' }}>Resuelto</option>
                    <option value="Cerrado" {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="categoria_id" class="form-label">Categoría</label>
                <select name="categoria_id" id="categoria_id" class="form-select">
                    <option value="">Todas</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}"
                            {{ request('categoria_id') == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="desde" class="form-label">Desde</label>
                <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
            </div>

            <div class="col-md-2">
                <label for="hasta" class="form-label">Hasta</label>
                <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
            </div>

            <div class="col-md-2">
                <label for="sin_agente" class="form-label">Agente</label>
                <select name="sin_agente" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('sin_agente') == '1' ? 'selected' : '' }}>Sin asignar</option>
                </select>
            </div>

            <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-lima">
                    <i class="bi bi-funnel-fill"></i> Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded shadow-sm border p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID Ticket</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Agente</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id_ticket }}</td>
                                <td>{{ $ticket->cliente_nombre }} {{ $ticket->cliente_apellido }}</td>
                                <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</td>
                                <td>{{ $ticket->agente->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill badge-lima">{{ $ticket->estado }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.tickets.show', ['ticket' => $ticket->id_ticket]) }}"
                                       class="btn btn-sm btn-outline-dark me-2" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-primary" title="Asignar agente"
                                            data-bs-toggle="modal"
                                            data-bs-target="#asignarAgenteModal"
                                            data-ticket-id="{{ $ticket->id_ticket }}">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay tickets registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $tickets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Asignar Agente --}}
    <div class="modal fade" id="asignarAgenteModal" tabindex="-1" aria-labelledby="asignarAgenteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form method="POST" action="{{ route('admin.tickets.asignar-agente') }}" class="w-100">
                @csrf
                <input type="hidden" name="ticket_id" id="ticket_id_modal">
                <div class="modal-content rounded-4 px-4 py-3">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold" id="asignarAgenteLabel">Asignar Agente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-start">
                            <label for="agente_id" class="form-label">Selecciona un agente</label>
                            <select name="agente_id" id="agente_id" class="form-select" required>
                                <option disabled selected>-- Seleccionar --</option>
                                @foreach ($agentes as $agente)
                                    <option value="{{ $agente->id }}">{{ $agente->nombre }} {{ $agente->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="submit" class="btn btn-lima w-100">Asignar</button>
                    </div>
                </div>
            </form>
        </div>        
    </div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('asignarAgenteModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const ticketId = button.getAttribute('data-ticket-id');
        document.getElementById('ticket_id_modal').value = ticketId;
    });
</script>
@endpush
