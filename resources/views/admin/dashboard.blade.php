@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Dashboard</h2>
    </div>

    {{-- Fila superior: Bienvenida + Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border text-center w-100 d-flex flex-column">
                <h5 class="fw-bold">Hola, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h5>
                <p class="text-muted mb-3">Explora el estado general de los tickets</p>
                <img src="{{ asset('images/Programming-amico.png') }}"
                 class="img-fluid mb-3 mx-auto d-block"
                 style="max-width: 180px; height: auto;">
                 <a href="#"
                 class="btn px-4 py-2 mx-auto"
                 style="background-color: #BAF266; color: #000; border: none; text-decoration: none;">
                 Ver Tickets <i class="bi bi-arrow-right-circle-fill ms-1 text-dark"></i>
                </a>



            </div>
        </div>

        <div class="col-md-8 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border w-100">
                <h5 class="fw-bold mb-3">Estado de Tickets</h5>
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-list-task fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $total }}</div>
                        <small>Total</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-lightbulb fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $abiertos }}</div>
                        <small>Abiertos</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-gear-wide-connected fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $en_proceso }}</div>
                        <small>En proceso</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-check-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $resueltos }}</div>
                        <small>Resueltos</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-x-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">{{ $cerrados }}</div>
                        <small>Cerrados</small>
                    </div>                    
                </div>
                
            </div>
        </div>
    </div>

    {{-- Gráfico + tabla --}}
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="bg-white rounded shadow-sm border p-4 text-center h-100">
                <h5 class="fw-bold mb-3">Tendencias de Tickets</h5>
                <canvas id="ticketsChart" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="bg-white rounded shadow-sm border p-4 h-100">
                <h5 class="mb-3 fw-bold">Últimos Tickets</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID Ticket</th>
                                <th>Solicitante</th>
                                <th>Fecha</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id_ticket }}</td>
                                    <td>{{ $ticket->cliente_nombre }} {{ $ticket->cliente_apellido }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $ticket->categoria_nombre ?? '-' }}</td>
                                    <td><span class="badge rounded-pill badge-lima">{{ $ticket->estado }}</span></td>
                                    <td>
                                    <a href="{{ route('admin.ticketdetalle', $ticket->id_ticket) }}"
                                    class="btn btn-sm rounded-circle"
                                    style="background-color: #BAF266; color: #000; border: none;">
                                    <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                    </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No hay tickets aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('ticketsChart').getContext('2d');

    const data = [
        {{ $abiertos }},
        {{ $en_proceso }},
        {{ $resueltos }},
        {{ $cerrados }}
    ];
    const total = data.reduce((a, b) => a + b, 0);

    const ticketsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Abiertos', 'En proceso', 'Resueltos', 'Cerrados'],
            datasets: [{
                label: 'Estado de Tickets',
                data: data,
                backgroundColor: ['#36A2EB', '#FFCE56', '#4CAF50', '#F44336'],
                borderColor: ['#fff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${context.label}: ${percentage}%`;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
