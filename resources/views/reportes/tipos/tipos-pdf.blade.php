<h3>Reporte de Tipos</h3>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Tipo</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $tipo)
        <tr>
            <td>{{ $tipo->id_tipo }}</td>
            <td>{{ $tipo->nombre_tipo }}</td>
            <td>{{ $tipo->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
