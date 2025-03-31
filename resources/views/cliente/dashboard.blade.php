@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Dashboard</h2>
        <a href="{{ route('tickets.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Crear nuevo ticket
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="p-4 bg-white rounded shadow-sm border text-center">
                <h5 class="fw-bold">Hola, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h5>
                <p class="text-muted mb-3">Echa un vistazo a tus tickets 😊</p>
                <img src="{{ asset('images/cliente-dashboard.svg') }}" alt="Usuario" class="img-fluid mb-3" style="max-height: 150px;">
                <a href="{{ route('tickets.index') }}" class="btn btn-success">
                    Ver tickets <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-4 bg-white rounded shadow-sm border text-center">
                <h5 class="fw-bold mb-3">Mis Tickets</h5>
                <div class="row justify-content-center g-3">
                    <div class="col-6 col-md-3">
                        <i class="bi bi-list-task fs-2 text-success"></i>
                        <div class="fw-bold fs-5">{{ $total }}</div>
                        <small>Total</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="bi bi-check-circle fs-2 text-success"></i>
                        <div class="fw-bold fs-5">{{ $resueltos }}</div>
                        <small>Resueltos</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="bi bi-gear-wide-connected fs-2 text-success"></i>
                        <div class="fw-bold fs-5">{{ $en_proceso }}</div>
                        <small>En Progreso</small>
                    </div>
                    <div class="col-6 col-md-3">
                        <i class="bi bi-clock-history fs-2 text-success"></i>
                        <div class="fw-bold fs-5">{{ $en_espera }}</div>
                        <small>En Espera</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <td>{{ $ticket->id }}</td>
                            <td>{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</td>
                            <td>{{ $ticket->created_at->diffForHumans() }}</td>
                            <td>{{ optional($ticket->agente)->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge rounded-pill bg-success text-dark">{{ $ticket->estado }}</span>
                            </td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-dark rounded-circle">
                                    <i class="bi bi-arrow-right-short fs-5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No hay tickets aún.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
