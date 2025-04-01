@extends('layouts.app')

@section('title', 'Dashboard Agente')

@section('content')
<div class="container py-4">

    <div class="row mb-4">
        <div class="col-md-6 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border text-center w-100">
                <h5 class="fw-bold">Hola, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h5>
                <p class="text-muted mb-3">Te han sido asignados <strong>{{ $total }}</strong> tickets</p>
                <img src="{{ asset('images/tech company-amico.png') }}" alt="Agente" class="img-fluid mb-3"
                    style="max-height: 150px;">
                <br>
                <a href="{{ route('agente.tickets') }}" class="btn btn-lima">
                    Ver Tickets <i class="bi bi-arrow-right-circle-fill ms-1 text-dark"></i>
                </a>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border text-center w-100">
                <h5 class="fw-bold mb-3">Estado de Tickets</h5>

                <div class="row text-center">
                    <div class="col-4 col-sm-4 mb-3">
                        <i class="bi bi-list-task fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $total }}</div>
                        <small>Total</small>
                    </div>
                    <div class="col-4 col-sm-4 mb-3">
                        <i class="bi bi-play-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $abiertos }}</div>
                        <small>Abiertos</small>
                    </div>
                    <div class="col-4 col-sm-4 mb-3">
                        <i class="bi bi-arrow-repeat fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $en_proceso }}</div>
                        <small>En Proceso</small>
                    </div>
                    <div class="col-4 col-sm-4 mb-3">
                        <i class="bi bi-check-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $resueltos }}</div>
                        <small>Resueltos</small>
                    </div>
                    <div class="col-4 col-sm-4">
                        <i class="bi bi-x-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $cerrados }}</div>
                        <small>Cerrados</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de tickets asignados --}}
    <div class="bg-white rounded shadow-sm border p-4">
        <h5 class="mb-3 fw-bold">Tickets Asignados</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID Ticket</th>
                        <th>Solicitante</th>
                        <th>Fecha</th>
                        <th>Área</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id_ticket }}</td>
                            <td>{{ $ticket->cliente->nombre }} {{ $ticket->cliente->apellido }}</td>
                            <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $ticket->categoria->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge rounded-pill badge-lima">{{ $ticket->estado }}</span>
                            </td>
                            <td>
                                <a href="{{ route('agente.tickets.show', $ticket->id_ticket) }}"
                                    class="btn btn-sm btn-lima rounded-circle">
                                    <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No tienes tickets asignados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
