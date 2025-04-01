@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
    <div class="container py-4">
    <div class="container py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard</h2>
            <button class="btn btn-lima" data-bs-toggle="modal" data-bs-target="#crearTicketModal">
                <i class="bi bi-plus-circle text-dark"></i> Crear nuevo ticket
            </button>

        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard</h2>
            <button class="btn btn-lima" data-bs-toggle="modal" data-bs-target="#crearTicketModal">
                <i class="bi bi-plus-circle text-dark"></i> Crear nuevo ticket
            </button>

        </div>


        <div class="row mb-4">
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="p-4 bg-white rounded shadow-sm border text-center w-100">
                    <h5 class="fw-bold">Hola, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h5>
                    <p class="text-muted mb-3">Echa un vistazo a tus tickets 😊</p>
                    <img src="{{ asset('images/Programming-amico.png') }}" alt="Usuario" class="img-fluid mb-3"
                        style="max-height: 150px;">
                    <br>
                    <a href="{{ route('tickets.index') }}" class="btn btn-lima">
                        Ver tickets <i class="bi bi-arrow-right-circle-fill ms-1 text-dark"></i>
                    </a>
                </div>
            </div>
                    <a href="{{ route('tickets.index') }}" class="btn btn-lima">
                        Ver tickets <i class="bi bi-arrow-right-circle-fill ms-1 text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-stretch">
                <div class="p-4 bg-white rounded shadow-sm border text-center w-100">
                    <h5 class="fw-bold mb-3">Mis Tickets</h5>

                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="row text-center">
                                <div class="col-6 col-sm-6 col-md-6 mb-4">
                                    <i class="bi bi-list-task fs-3 text-lima"></i>
                                    <div class="fw-bold fs-5">{{ $total }}</div>
                                    <small>Total</small>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 mb-4">
                                    <i class="bi bi-check-circle fs-3 text-lima"></i>
                                    <div class="fw-bold fs-5">{{ $resueltos }}</div>
                                    <small>Resueltos</small>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6">
                                    <i class="bi bi-gear-wide-connected fs-3 text-lima"></i>
                                    <div class="fw-bold fs-5">{{ $en_proceso }}</div>
                                    <small>En Progreso</small>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6">
                                    <i class="bi bi-clock-history fs-3 text-lima"></i>
                                    <div class="fw-bold fs-5">{{ $en_espera }}</div>
                                    <small>En Espera</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-md-block">
                            <img src="{{ asset('images/Hand coding-bro.png') }}" alt="Estadísticas" class="img-fluid"
                                style="max-height: 120px;">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Tabla de tickets --}}
        <div class="bg-white rounded shadow-sm border p-4">
            <h5 class="mb-3 fw-bold">Últimos Tickets</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID Ticket</th>
                            <th>Solicitante</th>
                            <th>Fecha</th>
                            <th>Agente</th>
                            <th>Área</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id_ticket }}</td>
                                <td>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</td>
                                <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ optional($ticket->agente)->nombre ?? 'Sin asignar' }}</td>
                                <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill badge-lima">{{ $ticket->estado }}</span>
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
                                <td colspan="7">No hay tickets aún.</td>
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
                    <form method="POST"
                        action="{{ route('tickets.store') }}">
                        @csrf
                <div class="modal-body">
                    <form method="POST"
                        action="{{ route('tickets.store') }}">
                        @csrf

                        <div class="mb-3
                        text-start">
                        <div class="mb-3
                        text-start">
                        <label for="titulo" class="form-label">Título de Problemática</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                </div>

                <div class="mb-3 text-start">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" required
                        placeholder="Por favor describe a detalle la situación y uno de nuestros técnicos se encargará de resolverla"></textarea>
                </div>
                <div class="mb-3 text-start">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" required
                        placeholder="Por favor describe a detalle la situación y uno de nuestros técnicos se encargará de resolverla"></textarea>
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
