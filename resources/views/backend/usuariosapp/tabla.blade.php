@php dd($usuarios); @endphp

<div class="table-responsive">
...

<div class="table-responsive">

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Nombre Completo</th>
            <th>Activo</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $item)
        <tr>
            <td>{{ $item->id_usuario }}</td>
            <td>{{ $item->usuario }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->nombre_completo }}</td>
            <td>
                @if($item->activo)
                    <span class="badge badge-success">Activo</span>
                @else
                    <span class="badge badge-danger">Inactivo</span>
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-info" onclick="verInformacion({{ $item->id_usuario }})">Editar</button>
            </td>
        </tr>
        @endforeach
        @if(count($usuarios) == 0)
        <tr>
            <td colspan="6" class="text-center">No hay registros</td>
        </tr>
        @endif
    </tbody>
</table>

</div>
