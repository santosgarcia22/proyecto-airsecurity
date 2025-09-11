@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Actualizar Persona</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.personas.update', $personas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $personas->nombre }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="identificacion" class="form-label">Identificación</label>
                        <input type="text" name="identificacion" class="form-control" value="{{ $personas->identificacion }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="empresa" class="form-label">Empresa</label>
                        <input type="text" name="empresa" class="form-control" value="{{ $personas->empresa }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="AGENTE" @selected($personas->rol == 'AGENTE')>Agente</option>
                            <option value="OFICIAL" @selected($personas->rol == 'OFICIAL')>Oficial</option>
                            <option value="COORDINADOR" @selected($personas->rol == 'COORDINADOR')>Coordinador</option>
                            <option value="LIDER_VUELO" @selected($personas->rol == 'LIDER_VUELO')>Líder Vuelo</option>
                            <option value="OTRO" @selected($personas->rol == 'OTRO')>Otro</option>
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('admin.personas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
