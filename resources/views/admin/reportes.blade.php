@extends('layouts.app')
@section('title', 'Reportes')
@section('content')
    <div class="container py-4">
        <h2 class="fw-bold mb-4"> Reportes</h2>

        <form class="row mb-4" method="GET">
            <div class="col-md-3">
                <label>Desde</label>
                <input type="date" name="inicio" class="form-control" value="{{ request('inicio') }}">
            </div>
            <div class="col-md-3">
                <label>Hasta</label>
                <input type="date" name="fin" class="form-control" value="{{ request('fin') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-dark w-100"><i class="bi bi-funnel-fill"></i> Filtrar</button>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('admin.reportes.excel', request()->query()) }}" class="btn btn-success w-100" style="background-color: #99d68f; color: #000; border: none;" ><i
                        class="bi bi-file-earmark-excel" ></i> Excel</a>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('admin.reportes.pdf', request()->query()) }}" class="btn btn-danger w-100" style="background-color: #baf266; color: #000; border: none;"><i
                        class="bi bi-file-earmark-pdf"></i> PDF</a>
            </div>
        </form>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                        <h5 class="card-title">Tickets por Estado</h5>
                        <canvas id="estadoChart" height="240"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                        <h5 class="card-title">Tickets por Categoría</h5>
                        <canvas id="categoriaChart" height="240"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body">
                        <h5 class="card-title">Tickets por Agente</h5>
                        <canvas id="agenteChart" height="260"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const estadoCtx = document.getElementById('estadoChart');
        new Chart(estadoCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($porEstado->toArray())) !!},
                datasets: [{
                    data: {!! json_encode(array_values($porEstado->toArray())) !!},
                    backgroundColor: ['#baf266', '#f6c23e', '#e74a3b', '#36b9cc']
                }]
            }
        });

        const categoriaLabels = {!! json_encode($porCategoria->sortDesc()->take(5)->keys()->map(fn($id) => $categorias[$id])->values()) !!};
        const categoriaData = {!! json_encode($porCategoria->sortDesc()->take(5)->values()) !!};

        new Chart(document.getElementById('categoriaChart'), {
            type: 'bar',
            data: {
                labels: categoriaLabels,
                datasets: [{
                    label: 'Tickets por Categoría',
                    data: categoriaData,
                    backgroundColor: '#baf266'
                }]
            }
        });

        const agenteLabels = {!! json_encode($porAgente->keys()->map(fn($id) => $agentes[$id])->values()) !!};
        const agenteData = {!! json_encode($porAgente->values()) !!};

        new Chart(document.getElementById('agenteChart'), {
            type: 'bar',
            data: {
                labels: agenteLabels,
                datasets: [{
                    label: 'Tickets por Agente',
                    data: agenteData,
                    backgroundColor: '#baf266'
                }]
            }
        });
    </script>
@endpush
