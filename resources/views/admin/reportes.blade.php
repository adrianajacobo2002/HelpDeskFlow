@extends('layouts.app')
@section('title', 'Reportes')
@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">📊 Reportes</h2>

    <form class="row mb-4" method="GET">
        <div class="col-md-3">
            <label>Desde</label>
            <input type="date" name="inicio" class="form-control" value="{{ request('inicio', $inicio->format('Y-m-d')) }}">
        </div>
        <div class="col-md-3">
            <label>Hasta</label>
            <input type="date" name="fin" class="form-control" value="{{ request('fin', $fin->format('Y-m-d')) }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-dark w-100"><i class="bi bi-funnel-fill"></i> Filtrar</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('admin.reportes.excel', request()->query()) }}" class="btn btn-success w-100"><i class="bi bi-file-earmark-excel"></i> Excel</a>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('admin.reportes.pdf', request()->query()) }}" class="btn btn-danger w-100"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
        </div>
    </form>

    <div class="row">
        <div class="col-md-6 mb-4">
            <canvas id="estadoChart"></canvas>
        </div>
        <div class="col-md-6 mb-4">
            <canvas id="categoriaChart"></canvas>
        </div>
        <div class="col-md-12 mb-4">
            <canvas id="agenteChart"></canvas>
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
                backgroundColor: '#4e73df'
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
                backgroundColor: '#1cc88a'
            }]
        }
    });
</script>
@endpush
