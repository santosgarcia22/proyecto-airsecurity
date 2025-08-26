<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>N° Llegando</th>
                <th>N° Saliendo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Matrícula</th>
                <th>Operador</th>
                <th style="width:130px">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vuelos as $v)
            <tr>
                <td>{{ optional($v->fecha)->format('Y-m-d') }}</td>
                <td>{{ $v->numero_vuelo_llegando }}</td>
                <td>{{ $v->numero_vuelo_saliendo }}</td>
                <td>{{ $v->origen }}</td>
                <td>{{ $v->destino }}</td>
                <td>{{ $v->matricula }}</td>
                <td>{{ optional($v->operador)->nombre }}</td>
                <td class="text-center">
                    <a class="btn btn-xs btn-info" href="{{ route('admin.vuelo.show',$v) }}">Ver</a>
                    <a class="btn btn-xs btn-warning" href="{{ route('admin.vuelo.edit',$v) }}">Editar</a>
                    <form action="{{ route('admin.vuelo.destroy',$v) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('¿Eliminar vuelo?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-xs btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No se encontraron registros</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-2">
    {{ $vuelos->links() }}
</div>