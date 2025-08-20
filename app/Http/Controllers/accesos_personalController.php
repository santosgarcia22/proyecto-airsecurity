<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\controlAero;
use App\Models\accesos_personal;
use Illuminate\Support\Facades\Storage;


class accesos_personalController extends Controller
{
    //

    // Listar accesos de un control (para la tabla del modal)
    public function index(\App\Models\controlAero $control)
    {
        return response()->json($control->accesos()->orderByDesc('id_personal')->get());
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'control_id'     => 'required|exists:control_aeronave,id_control_aeronave',
            'nombre'         => 'required|string|max:150',
            'id'             => 'nullable|string|max:50',
            'hora_entrada'   => 'nullable|date_format:H:i',
            'hora_salida'    => 'nullable|date_format:H:i|after_or_equal:hora_entrada',
            'hora_entrada1'  => 'nullable|date_format:H:i',
            'hora_salida1'   => 'nullable|date_format:H:i',
            'herramientas'   => 'nullable|string|max:255',
            'empresa'        => 'nullable|string|max:150',
            'motivo'         => 'nullable|string|max:400',
            'firma'          => 'nullable|file|mimes:jpg,jpeg,png,webp,heic|max:4096',
        ]);

        if ($req->hasFile('firma')) {
            $data['firma'] = $req->file('firma')->store('firmas_acceso', 'public');
        }

        $row = \App\Models\accesos_personal::create($data);

        // Si la petición espera JSON (AJAX)
        if ($req->expectsJson() || $req->ajax()) {
            return response()->json(['ok' => true, 'row' => $row], 201);
        }

        // Petición normal (no AJAX)
        return back()->with('ok', 'Acceso agregado.');
    }


    public function destroy(accesos_personal $acceso) // ← ya tipa bien al alias
    {
        if ($acceso->firma && Storage::disk('public')->exists($acceso->firma)) {
            Storage::disk('public')->delete($acceso->firma);
        }
        $acceso->delete();
        return response()->json(['ok'=>true]);
    }

}