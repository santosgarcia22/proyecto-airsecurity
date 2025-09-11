<div class="table-responsive">
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th data-col="fecha">Fecha <span class="sort-icon"></span></th>
                    <th data-col="numero_vuelo_llegando">N° Llegando <span class="sort-icon"></span></th>
                    <th data-col="numero_vuelo_saliendo">N° Saliendo <span class="sort-icon"></span></th>
                    <th data-col="origen">Origen <span class="sort-icon"></span></th>
                    <th data-col="destino">Destino <span class="sort-icon"></span></th>
                    <th data-col="matricula">Matrícula <span class="sort-icon"></span></th>
                    <th data-col="operador">Operador <span class="sort-icon"></span></th>
                    <th style="width: 180px">Opciones</th>
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
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('admin.vuelo.show',$v) }}" class="btn btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.vuelo.edit',$v) }}" class="btn btn-primary" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button class="btn btn-danger btn-eliminar"
                                data-url="{{ route('admin.vuelo.destroy', $v->id) }}" data-token="{{ csrf_token() }}"
                                title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
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

    <div class="d-flex justify-content-center mt-2">
        {{ $vuelos->links() }}
    </div>



    {{-- Scripts --}}
    @yield('scripts')


    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/delete.js') }}"></script>

    @section('archivos-js')
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>

    < @endsection