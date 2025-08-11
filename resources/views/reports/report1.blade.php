<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Accesos</title>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        margin: 20px;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
    }

    th,
    td {
        border: 1px solid #333;
        padding: 6px 4px;
        text-align: left;
        font-size: 10px;
    }

    th {
        background-color: #f2f2f2;
    }

    .highlight {
        background-color: #ffe4c4;
    }
    </style>
</head>

<body>
    <h1>Listado de Accesos</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Posición</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Sincronización</th>
                <th>ID</th>
                <th>Objetos</th>
                <th>Vuelo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
            <tr>
                <td class="highlight">{{ $index + 1 }}</td>
                <td>{{ $item['nombre'] }}</td>
                <td>{{ $item['tipo'] }}</td>
                <td>{{ $item['posicion'] }}</td>
                <td>{{ $item['ingreso'] }}</td>
                <td>{{ $item['salida'] }}</td>
                <td>{{ $item['Sicronizacion'] }}</td>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['objetos'] }}</td>
                <td>{{ $item['vuelo'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>