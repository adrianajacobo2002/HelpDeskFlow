<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Reporte de Tickets</h1>

    <h3>Tickets por Estado</h3>
    <table>
        <thead><tr><th>Estado</th><th>Total</th></tr></thead>
        <tbody>
            @forelse ($porEstado as $estado => $cantidad)
                <tr><td>{{ ucfirst($estado) }}</td><td>{{ $cantidad }}</td></tr>
            @empty
                <tr><td colspan="2">No hay datos disponibles.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Tickets por Categoría</h3>
    <table>
        <thead><tr><th>Categoría</th><th>Total</th></tr></thead>
        <tbody>
            @forelse ($porCategoria as $categoria => $cantidad)
                <tr><td>{{ $categoria }}</td><td>{{ $cantidad }}</td></tr>
            @empty
                <tr><td colspan="2">No hay datos disponibles.</td></tr>
            @endforelse
        </tbody>
    </table>
    <h3>Rendimiento por Agente</h3>
    <table>
        <thead><tr><th>Agente</th><th>Tickets Atendidos</th></tr></thead>
        <tbody>
            @forelse ($porAgente as $agente => $cantidad)
                <tr><td>{{ $agente }}</td><td>{{ $cantidad }}</td></tr>
            @empty
                <tr><td colspan="2">No hay datos disponibles.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
