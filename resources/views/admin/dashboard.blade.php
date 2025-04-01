@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Dashboard</h2>
    </div>

    {{-- Fila superior: Bienvenida + Estadísticas --}}
    <div class="row mb-4">
        {{-- Card Bienvenida --}}
        <div class="col-md-4 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border text-center w-100">
                <h5 class="fw-bold">Hola, Admin</h5>
                <p class="text-muted mb-3">Explora el estado general de los tickets</p>
                <img src="{{ asset('images/Programming-amico.png') }}" class="img-fluid mb-3" style="max-height: 120px;">
                <a href="#" class="btn btn-lima">
                    Ver Tickets <i class="bi bi-arrow-right-circle-fill ms-1 text-dark"></i>
                </a>
            </div>
        </div>

        {{-- Card Estadísticas --}}
        <div class="col-md-8 d-flex align-items-stretch">
            <div class="p-4 bg-white rounded shadow-sm border w-100">
                <h5 class="fw-bold mb-3">Estado de Tickets</h5>
                <div class="row text-center">
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-list-task fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">10</div>
                        <small>Total</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-check-circle fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">2</div>
                        <small>Resueltos</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-gear-wide-connected fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">6</div>
                        <small>En Progreso</small>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <i class="bi bi-clock-history fs-3 text-lima"></i>
                        <div class="fw-bold fs-5">2</div>
                        <small>En Espera</small>
                    </div>
                </div>
                <div class="text-center d-none d-md-block">
                    <img src="{{ asset('images/Hand coding-bro.png') }}" alt="Estadísticas" class="img-fluid" style="max-height: 120px;">
                </div>
            </div>
        </div>
    </div>

    {{-- Gráfico + tabla --}}
    <div class="row">
        {{-- Doughnut Chart --}}
        <div class="col-md-4 mb-4">
            <div class="bg-white rounded shadow-sm border p-4 text-center h-100">
                <h5 class="fw-bold mb-3">Tendencias de Tickets</h5>
                <canvas id="ticketsChart" height="200"></canvas>
            </div>
        </div>

        {{-- Tabla estática --}}
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
                            <tr>
                                <td>0123456789</td>
                                <td>Jose P.</td>
                                <td>31/03/25</td>
                                <td>Bases de datos</td>
                                <td><span class="badge rounded-pill badge-lima">Pendiente</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-lima rounded-circle">
                                        <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>9876543210</td>
                                <td>Maria R.</td>
                                <td>30/03/25</td>
                                <td>Redes</td>
                                <td><span class="badge rounded-pill badge-lima">En Proceso</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-lima rounded-circle">
                                        <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>4567891230</td>
                                <td>Carlos L.</td>
                                <td>29/03/25</td>
                                <td>Soporte</td>
                                <td><span class="badge rounded-pill badge-lima">Resuelto</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-lima rounded-circle">
                                        <i class="bi bi-arrow-right-short fs-5 text-dark"></i>
                                    </a>
                                </td>
                            </tr>
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

    const ticketsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Resueltos', 'En Progreso', 'En Espera', 'Cerrados'],
            datasets: [{
                label: 'Estado de Tickets',
                data: [2, 6, 2, 0],
                backgroundColor: [
                    '#4CAF50',
                    '#FFCE56',
                    '#FFA500',
                    '#F44336'
                ],
                borderColor: ['#fff'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
