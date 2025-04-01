<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
        font-family: 'Poppins', sans-serif;
    }
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 14px;
            color: #222;
            margin: 0 40px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .logo {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .logo img {
            width: 120px;
        }

        .table-section {
            margin-bottom: 35px;
        }

        h3 {
            margin-bottom: 10px;
            color: #1e1e1e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px 8px;
            text-align: left;
        }

        th {
            background-color: #baf266;
            color: #000;
            font-weight: bold;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .small-text {
            font-size: 12px;
            color: #555;
        }
    </style>
</head>
<body>
    
    <h1>Reporte de Tickets</h1>

    <div class="table-section">
        <h3>Tickets por Estado</h3>
        <table>
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
                    <tr><td colspan="2">No hay datos disponibles.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-section">
        <h3>Tickets por Categoría</h3>
        <table>
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
                    <tr><td colspan="2">No hay datos disponibles.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-section">
        <h3>Rendimiento por Agente</h3>
        <table>
            <thead>
                <tr>
                    <th>Agente</th>
                    <th>Tickets resueltos</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($porAgente as $agente => $cantidad)
                    <tr>
                        <td>{{ $agente }}</td>
                        <td>{{ $cantidad }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2">No hay datos disponibles.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
