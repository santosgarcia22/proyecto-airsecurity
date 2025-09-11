@extends('backend.menus.superior')

@section('content-admin-css')
<link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet" />
@stop

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Registrar Persona</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.personas.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="identificacion" class="form-label">Identificación</label>
                        <input type="text" name="identificacion" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="empresa" class="form-label">Empresa</label>
                        <input type="text" name="empresa" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="AGENTE">Agente</option>
                            <option value="OFICIAL">Oficial</option>
                            <option value="COORDINADOR">Coordinador</option>
                            <option value="LIDER_VUELO">Líder Vuelo</option>
                            <option value="OTRO">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="{{ route('admin.personas.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
