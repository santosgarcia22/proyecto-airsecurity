<table class="table table-bordered table-hover table-sm">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Posición</th>
            <th>Numero de vuelo</th>
            <th>Ingreso</th>
            <th>Salida</th>
            <th>ID</th>
            <th>Sincronización</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $item)
        <tr>
            <td>{{ $item->numero_id}}</td>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->tipoRelacion->nombre_tipo ?? 'Sin tipo' }}</td>
            <td>{{ $item->posicion }}</td>
            <td>{{ $item->vueloRelacion->numero_vuelo ?? 'Sin vuelo' }}</td>
            <td>{{ $item->ingreso }}</td>
            <td>{{ $item->salida }}</td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->Sicronizacion }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $data->appends(request()->query())->links() }}