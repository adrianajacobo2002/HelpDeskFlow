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

        <form method="GET" class="mb-4">
            <div class="d-flex flex-wrap align-items-end gap-3">
                <div>
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="">Todos</option>
                        <option value="Abierto" {{ request('estado') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="En proceso" {{ request('estado') == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="Resuelto" {{ request('estado') == 'Resuelto' ? 'selected' : '' }}>Resuelto</option>
                        <option value="Cerrado" {{ request('estado') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>
        
                <div>
                    <label for="prioridad" class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select">
                        <option value="">Todas</option>
                        <option value="Baja" {{ request('prioridad') == 'Baja' ? 'selected' : '' }}>Baja</option>
                        <option value="Media" {{ request('prioridad') == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Alta" {{ request('prioridad') == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Urgente" {{ request('prioridad') == 'Urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
        
                <div>
                    <label for="categoria_id" class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria }}"
                                {{ request('categoria_id') == $categoria->id_categoria ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div>
                    <label for="desde" class="form-label">Desde</label>
                    <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
                </div>
        
                <div>
                    <label for="hasta" class="form-label">Hasta</label>
                    <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
                </div>
        
                <div class="ms-auto">
                    <button class="btn btn-lima" type="submit">
                        <i class="bi bi-funnel-fill"></i> Filtrar
                    </button>
                </div>
            </div>
        </form>
        

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
                                <td>{{ $ticket->agente ? $ticket->agente->nombre . ' ' . $ticket->agente->apellido : 'Sin asignar' }}
                                </td>
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

    <!-- Modal: Crear Ticket -->
    <div class="modal fade" id="crearTicketModal" tabindex="-1" aria-labelledby="crearTicketLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="crearTicketLabel">
                        <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" style="height: 32px;"> Crear
                        Ticket
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('tickets.store') }}">
                        @csrf

                        <div class="mb-3 text-start">
                            <label for="titulo" class="form-label">Título de Problemática</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" required
                                placeholder="Por favor describe a detalle la situación..."></textarea>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="prioridad" class="form-label">Prioridad</label>
                            <select class="form-select" name="prioridad" required>
                                <option value="" selected disabled>Seleccione una prioridad</option>
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                                <option value="Urgente">Urgente</option>
                            </select>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <select class="form-select" name="categoria_id" required>
                                <option value="" selected disabled>Seleccione una categoría</option>
                                @foreach ($categorias ?? [] as $categoria)
                                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-lima w-100">Crear Ticket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#baf266',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif
@endpush

