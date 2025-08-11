<table class="table table-bordered table-hover">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>fecha</th>
            <th>Numero de vuelos</th>
            <th>Matricula</th>
            <th>Destino</th>
            <th>Origen</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $vuelo)
        <tr>
            <td>{{ $vuelo->id_vuelo }}</td>
              <td>{{ $vuelo->fecha }}</td>
            <td>{{ $vuelo->numero_vuelo }}</td>
            <td>{{ $vuelo->matricula }}</td>
              <td>{{ $vuelo->destino }}</td>
            <td>{{ $vuelo->origen }}</td>
          
        </tr>
        @endforeach
    </tbody>
</table>
<div class="mt-2">
    {{ $data->links() }}
</div>
