<h3>Reporte de Tipos</h3>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Numero de vuelo</th>
            <th>Matricula</th>
            <th>Destino</th>
            <th>Origen</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $vuelos)
        <tr>
            <td>{{ $vuelos->id_vuelo }}</td>
            <td>{{ $vuelos->numero_vuelo }}</td>
            <td>{{ $vuelos->matricula }}</td>
            <td>{{ $vuelos->destino }}</td>
            <td>{{ $vuelos->origen }}</td>
            <td>{{ $vuelos->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
