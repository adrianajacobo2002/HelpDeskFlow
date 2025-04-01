<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Tickets</title>
</head>
<body>
    <h2>Tickets por Estado</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($porEstado as $estado => $cantidad)
                <tr>
                    <td>{{ ucfirst($estado) }}</td>
                    <td>{{ $cantidad }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Tickets por Categoría</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($porCategoria as $categoria => $cantidad)
                <tr>
                    <td>{{ $categoria }}</td>
                    <td>{{ $cantidad }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Rendimiento por Agente</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Agente</th>
                <th>Tickets Atendidos</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($porAgente as $agente => $cantidad)
                <tr>
                    <td>{{ $agente }}</td>
                    <td>{{ $cantidad }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay datos disponibles</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
