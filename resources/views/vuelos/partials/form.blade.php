@php
$v = $mode=='edit' ? $vuelo : null;
@endphp



<div class="container">

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required
                value="{{ old('fecha', optional($v->fecha ?? null)->format('Y-m-d')) }}">
        </div>

        <div class="form-group col-md-2">
            <label>Origen</label>
            <input type="text" name="origen" class="form-control" maxlength="10"
                value="{{ old('origen', $v->origen ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label>Destino</label>
            <input type="text" name="destino" class="form-control" maxlength="10"
                value="{{ old('destino', $v->destino ?? '') }}">
        </div>

        <div class="form-group col-md-3">
            <label>Operador</label>
            <select name="operador_id" class="form-control" required>
                <option value="">-- Seleccione --</option>
                @foreach($operadores as $op)
                <option value="{{ $op->id }}"
                    {{ (string)old('operador_id', $v->operador_id ?? '')===(string)$op->id?'selected':'' }}>
                    {{ $op->nombre }} ({{ $op->codigo }})
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-2">
            <label>Matrícula</label>
            <input type="text" name="matricula" class="form-control"
                value="{{ old('matricula', $v->matricula ?? '') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>N° vuelo llegando</label>
            <input type="text" name="numero_vuelo_llegando" class="form-control"
                value="{{ old('numero_vuelo_llegando', $v->numero_vuelo_llegando ?? '') }}">
        </div>

        <div class="form-group col-md-3">
            <label>N° vuelo saliendo</label>
            <input type="text" name="numero_vuelo_saliendo" class="form-control"
                value="{{ old('numero_vuelo_saliendo', $v->numero_vuelo_saliendo ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label>Posición llegada</label>
            <input type="text" name="posicion_llegada" class="form-control"
                value="{{ old('posicion_llegada', $v->posicion_llegada ?? '') }}">
        </div>

        <div class="form-group col-md-2">
            <label>Total Pax</label>
            <input type="number" name="total_pax" class="form-control" min="0"
                value="{{ old('total_pax', $v->total_pax ?? '') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Hora llegada real</label>
            <input type="datetime-local" name="hora_llegada_real" class="form-control"
                value="{{ old('hora_llegada_real', isset($v->hora_llegada_real) ? $v->hora_llegada_real->format('Y-m-d\TH:i') : '') }}">
        </div>
        <div class="form-group col-md-3">
            <label>Hora salida itinerario</label>
            <input type="datetime-local" name="hora_salida_itinerario" class="form-control"
                value="{{ old('hora_salida_itinerario', isset($v->hora_salida_itinerario) ? $v->hora_salida_itinerario->format('Y-m-d\TH:i') : '') }}">
        </div>
        <div class="form-group col-md-3">
            <label>Hora salida pushback</label>
            <input type="datetime-local" name="hora_salida_pushback" class="form-control"
                value="{{ old('hora_salida_pushback', isset($v->hora_salida_pushback) ? $v->hora_salida_pushback->format('Y-m-d\TH:i') : '') }}">
        </div>
    </div>


</div>


@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif