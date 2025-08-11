<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre Tipo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $tipo)
        <tr>
            <td>{{ $tipo->id_tipo }}</td>
            <td>{{ $tipo->nombre_tipo }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-2">
    {{ $data->links() }}
</div>
