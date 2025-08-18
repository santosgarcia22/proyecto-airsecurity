@php
    use Carbon\Carbon;
    $fechaCab = $header->fecha ? Carbon::parse($header->fecha)->format('Y-m-d') : '';
    $faltantes = max(0, ($maxRows ?? 32) - $rows->count());
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Control Acceso Aeronave</title>
<style>
    /* —— Tipografías / reset ———————————————————————————— */
    html, body {
        font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #000;
    }
    * { box-sizing: border-box; }
    .w-100 { width: 100%; }
    .text-center { text-align: center; }
    .text-right  { text-align: right; }
    .bold { font-weight: bold; }
    .mt-4 { margin-top: 8px; }

    /* —— Tablas / bordes ———————————————————————————— */
    table.box { border-collapse: collapse; width: 100%; }
    table.box th, table.box td {
        border: 1px solid #000;
        padding: 3px 4px;
        vertical-align: middle;
    }
    .gray { background: #f2f2f2; }
    .hcell { height: 18px; }

    /* Fija márgenes del PDF */
    @page { margin: 12px; }
    body { margin: 12px; }
</style>
</head>
<body>

<!-- ——— Encabezado superior ——— -->
<table class="box">
    <tr>
        <td style="width:35%">
            Programa de Seguridad<br>
            <b>TACA INTERNATIONAL</b>
        </td>
        <td class="text-center" style="width:30%">
            <b>Anexos</b><br>
            Control de acceso aeronave y<br>
            Diamante de seguridad
        </td>
        <td style="width:20%">
            <b>Fecha:</b> {{ Carbon::now()->format('d-M-y') }}<br>
            <b>Rev.:</b> 28
        </td>
        <td style="width:15%">
            <b>Anexo Q</b><br>
            <b>Página:</b> 2
        </td>
    </tr>
</table>

<!-- ——— Título ——— -->
<table class="box mt-4">
    <tr>
        <th class="text-center" style="font-size:12px">CONTROL ACCESO AERONAVE</th>
    </tr>
</table>

<!-- ——— Cabecera de vuelo ——— -->
<table class="box mt-4">
    <tr>
        <td><b>Fecha:</b> {{ $fechaCab }}</td>
        <td><b>Origen:</b> {{ $header->origen }}</td>
        <td><b>Destino:</b> {{ $header->destino }}</td>
        <td><b>N° Vuelo:</b> {{ $header->numero_vuelo }}</td>
        <td><b>Total Pax:</b> {{ $header->total_pax }}</td>
    </tr>
    <tr>
        <td><b>Hora llegada:</b> {{ $header->hora_llegada }}</td>
        <td><b>Posición:</b> {{ $header->posicion_llegada }}</td>
        <td colspan="2"><b>Matrícula/Operador:</b> {{ $header->matricula_operador }}</td>
        <td><b>Hora real salida:</b> {{ $header->hora_real_salida }}</td>
    </tr>
    <tr>
        <td colspan="2"><b>Coordinador/Líder:</b> {{ $header->coordinador_lider }}</td>
        <td><b>Desab. ini:</b> {{ $header->desabordaje_inicio }}</td>
        <td><b>Desab. fin:</b> {{ $header->desabordaje_fin }}</td>
        <td><b>Tripulación ingreso:</b> {{ $header->tripulacion_ingreso }}</td>
    </tr>
    <tr>
        <td><b>Insp. cabina ini:</b> {{ $header->inspeccion_cabina_inicio }}</td>
        <td><b>Insp. cabina fin:</b> {{ $header->inspeccion_cabina_fin }}</td>
        <td><b>Aseo ing.:</b> {{ $header->aseo_ingreso }}</td>
        <td><b>Aseo sal.:</b> {{ $header->aseo_salida }}</td>
        <td><b>Salida Itinerario:</b> {{ $header->salida_itinerario }}</td>
    </tr>
    <tr>
        <td><b>Abordaje ini:</b> {{ $header->abordaje_inicio }}</td>
        <td><b>Abordaje fin:</b> {{ $header->abordaje_fin }}</td>
        <td><b>Cierre puertas:</b> {{ $header->cierre_puertas }}</td>
        <td colspan="2">
            <b>Demora:</b> {{ $header->demora_tiempo }} &nbsp;|&nbsp;
            <b>Motivo:</b> {{ $header->demora_motivo }}
        </td>
    </tr>
    <tr>
        <td colspan="2"><b>Agente nombre:</b> {{ $header->agente_nombre }}</td>
        <td><b>Agente ID:</b> {{ $header->agente_id }}</td>
        <td colspan="2"><b>Agente Firma:</b> {{ $header->agente_firma }}</td>
    </tr>
</table>

<!-- ——— Tabla de personas ——— -->
<table class="box mt-4">
    <thead>
        <tr class="gray">
            <th style="width:3%">#</th>
            <th style="width:22%">Nombre completo</th>
            <th style="width:8%">ID</th>
            <th style="width:8%">Hora<br>Entrada</th>
            <th style="width:8%">Hora<br>Salida</th>
            <th style="width:8%">Hora<br>Entrada 2</th>
            <th style="width:8%">Hora<br>Salida 2</th>
            <th style="width:12%">Herramientas</th>
            <th style="width:12%">Empresa / Área</th>
            <th style="width:13%">Motivo / Entrada</th>
            <th style="width:8%">Firma</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $i => $r)
            <tr>
                <td class="text-center hcell">{{ $i + 1 }}</td>
                <td class="hcell">{{ $r->nombre }}</td>
                <td class="text-center hcell">{{ $r->id }}</td>
                <td class="text-center hcell">{{ $r->hora_entrada }}</td>
                <td class="text-center hcell">{{ $r->hora_salida }}</td>
                <td class="text-center hcell">{{ $r->hora_entrada1 }}</td>
                <td class="text-center hcell">{{ $r->hora_salida1 }}</td>
                <td class="hcell">{{ $r->herramientas }}</td>
                <td class="hcell">{{ $r->empresa }}</td>
                <td class="hcell">{{ $r->motivo }}</td>
                <td class="hcell">{{ $r->firma }}</td>
            </tr>
        @endforeach

        {{-- Rellena filas en blanco para mantener siempre el alto de la planilla --}}
        @for ($k = 0; $k < $faltantes; $k++)
            <tr>
                <td class="hcell">&nbsp;</td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
                <td class="hcell"></td>
            </tr>
        @endfor
    </tbody>
</table>

<!-- ——— Observaciones ——— -->
<table class="box mt-4">
    <tr>
        <td style="height:28px"><b>OBSERVACIONES:</b></td>
    </tr>
</table>

</body>
</html>
