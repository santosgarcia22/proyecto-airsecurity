<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\controlAero;
use App\Models\accesos_personal;
use Illuminate\Support\Facades\Storage;


class ControlAeronaveController extends Controller
{
    //

    public function index(Request $request)
    {
        // filtros simples
        $q = controlAero::query();

        if ($request->filled('numero_vuelo')) {
            $q->where('numero_vuelo', 'like', '%'.$request->numero_vuelo.'%');
        }
        if ($request->filled('fecha')) {
            $q->whereDate('fecha', $request->fecha);
        }

        $items = $q->orderByDesc('id_control_aeronave')->paginate(10);

        return view('controlaeronave.index', compact('items'));
    }


    public function create()
    {
        return view('controlaeronave.create');

    }


     public function store(Request $request)
    {
        $data = $request->validate([
            // base
            'fecha' => 'nullable|date',
            'origen' => 'nullable|string|max:100',
            'numero_vuelo' => 'required|string|max:50',
            'hora_llegada' => 'nullable|date_format:H:i',
            'posicion_llegada' => 'nullable|string|max:100',
            'matricula_operador' => 'nullable|string|max:200',
            'coordinador_lider' => 'nullable|string|max:150',

            // tiempos
            'desabordaje_inicio' => 'nullable|date_format:H:i',
            'desabordaje_fin' => 'nullable|date_format:H:i',
            'inspeccion_cabina_inicio' => 'nullable|date_format:H:i',
            'inspeccion_cabina_fin' => 'nullable|date_format:H:i',
            'aseo_ingreso' => 'nullable|date_format:H:i',
            'aseo_salida' => 'nullable|date_format:H:i',
            'tripulacion_ingreso' => 'nullable|date_format:H:i',
            'salida_itinerario' => 'nullable|date_format:H:i',
            'abordaje_inicio' => 'nullable|date_format:H:i',
            'abordaje_fin' => 'nullable|date_format:H:i',
            'cierre_puertas' => 'nullable|date_format:H:i',

            // seguridad
            'agente_nombre' => 'nullable|string|max:150',
            'agente_id' => 'nullable|string|max:100',
            'agente_firma' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',

            // demoras / pax
            'demora_tiempo' => 'nullable|integer|min:0',
            'demora_motivo' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:100',
            'total_pax' => 'nullable|integer|min:0',
            'hora_real_salida' => 'nullable|date_format:H:i',

            //datos de accesos
            'nombre' => 'nullable|string|max:100',
            'id' => 'nullable|string|max:20',
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'hora_entrada1' => 'nullable|date_format:H:i',
            'hora_salida1' => 'nullable|date_format:H:i',
            'herramientas' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:50',
            'motivo' => 'nullable|string|max:50',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',


        ]);

        if ($request->hasFile('firma')) {
            $data['firma'] = $request->file('firma')->store('firmas', 'public');
        }

        controlAero::create($data);

        return redirect()->route('admin.controlaeronave.show')->with('success', 'Registro creado');
    }




    public function storeAcceso(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255',
            'id' => 'nullable|string|max:20', // ojo: lo pusiste integer, pero en tu modelo es string
            'hora_entrada' => 'nullable|date_format:H:i',
            'hora_salida' => 'nullable|date_format:H:i',
            'hora_entrada1' => 'nullable|date_format:H:i',
            'hora_salida1' => 'nullable|date_format:H:i',
            'herramientas' => 'nullable|string|max:255',
            'empresa' => 'nullable|string|max:255',
            'motivo' => 'nullable|string|max:500',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',
        ]);

        $data = $request->only([
            'nombre',
            'id',
            'hora_entrada',
            'hora_salida',
            'hora_entrada1',
            'hora_salida1',
            'herramientas',
            'empresa',
            'motivo',
        ]);

        if ($request->hasFile('firma')) {
            $data['firma'] = $request->file('firma')->store('firmas', 'public');
        }

        controlAero::create($data);

        return redirect()->back()->with('success', 'Registro de acceso guardado con éxito.');
    }



    public function edit(controlAero $control)
    {
        return view('controlaeronave.edit', compact('control'));
    }

    public function update(Request $request, controlAero $control)
    {

          // 1️⃣ Convertir strings vacíos en null antes de validar
            $request->merge(
                array_map(function ($value) {
                    return $value === '' ? null : $value;
                }, $request->all())
            );

        $data = $request->validate([
            'fecha' => 'sometimes|nullable|date',
            'origen' => 'sometimes|nullable|string|max:100',
            'numero_vuelo' => 'sometimes|nullable|string|max:50',
            'hora_llegada' => 'sometimes|nullable|date_format:H:i',
            'posicion_llegada' => 'sometimes|nullable|string|max:100',
            'matricula_operador' => 'sometimes|nullable|string|max:200',
            'coordinador_lider' => 'sometimes|nullable|string|max:150',

            'desabordaje_inicio' => 'sometimes|nullable|date_format:H:i',
            'desabordaje_fin' => 'sometimes|nullable|date_format:H:i',
            'inspeccion_cabina_inicio' => 'sometimes|nullable|date_format:H:i',
            'inspeccion_cabina_fin' => 'sometimes|nullable|date_format:H:i',
            'aseo_ingreso' => 'sometimes|nullable|date_format:H:i',
            'aseo_salida' => 'sometimes|nullable|date_format:H:i',
            'tripulacion_ingreso' => 'sometimes|nullable|date_format:H:i',
            'salida_itinerario' => 'sometimes|nullable|date_format:H:i',
            'abordaje_inicio' => 'sometimes|nullable|date_format:H:i',
            'abordaje_fin' => 'sometimes|nullable|date_format:H:i',
            'cierre_puertas' => 'sometimes|nullable|date_format:H:i',

            'agente_nombre' => 'sometimes|nullable|string|max:150',
            'agente_id' => 'sometimes|nullable|string|max:100',
            'agente_firma' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',

            'demora_tiempo' => 'sometimes|nullable|integer|min:0',
            'demora_motivo' => 'sometimes|nullable|string|max:255',
            'destino' => 'sometimes|nullable|string|max:100',
            'total_pax' => 'sometimes|nullable|integer|min:0',
            'hora_real_salida' => 'sometimes|nullable|date_format:H:i',

            'nombre' => 'sometimes|nullable|string|max:100',
            'id' => 'sometimes|nullable|string|max:20',
            'hora_entrada' => 'sometimes|nullable|date_format:H:i',
            'hora_salida' => 'sometimes|nullable|date_format:H:i',
            'hora_entrada1' => 'sometimes|nullable|date_format:H:i',
            'hora_salida1' => 'sometimes|nullable|date_format:H:i',
            'herramientas' => 'sometimes|nullable|string|max:100',
            'empresa' => 'sometimes|nullable|string|max:50',
            'motivo' => 'sometimes|nullable|string|max:50',
            'firma' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,webp,heic|max:4096',
        ]);

        if ($request->hasFile('agente_firma')) {
            // Opcional: borrar firma anterior
            if ($control->agente_firma && Storage::disk('public')->exists($control->agente_firma)) {
                Storage::disk('public')->delete($control->agente_firma);
            }
            $data['agente_firma'] = $request->file('agente_firma')->store('firmas', 'public');
        }


        if ($request->hasFile('firma')) {
            // Opcional: borrar firma anterior
            if ($control->firma && Storage::disk('public')->exists($control->firma)) {
                Storage::disk('public')->delete($control->firma);
            }
            $data['firma'] = $request->file('firma')->store('firmas', 'public');
        }

        // Filtrar valores null para que no sobreescriban
        $data = collect($data)
        ->filter(function ($value, $key) use ($control) {
            return $value !== $control->$key;
        })->toArray();

        $control->update($data);

        return redirect()->route('admin.controlaeronave.show')->with('success', 'Registro actualizado');
    }

     public function destroy(controlAero $control)
    {
        // Opcional: borrar firma
        if ($control->agente_firma && Storage::disk('public')->exists($control->agente_firma)) {
            Storage::disk('public')->delete($control->agente_firma);
        }
        $control->delete();
        return response()->json(['res' => true]);
    }


    public function show($id)
    {
        $control = controlAero::with('accesos')->findOrFail($id);
        return view('control_aeronave.show', compact('control'));
    }



    




}