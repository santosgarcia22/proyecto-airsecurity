<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 4px;
        text-align: left;
    }

    th {
        background-color: #eee;
    }
    </style>
</head>

<body>
    <h2 align="center">Reporte de Accesos</h2>
    <p>Fecha de generación: {{ now() }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Posición</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Numero de vuelo</th>
                <th>Sincronización</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
            <tr>
                <td>{{ $item->numero_id }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->tipoRelacion->nombre_tipo ?? 'Sin tipo' }}</td>
                <td>{{ $item->posicion }}</td>
                <td>{{ $item->ingreso }}</td>
                <td>{{ $item->salida }}</td>
                <td>{{ $item->vueloRelacion->numero_vuelo ?? 'Sin vuelo' }}</td>
                <td>{{ $item->Sicronizacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>