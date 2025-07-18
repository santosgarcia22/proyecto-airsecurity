<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vuelo;

class VueloAppController extends Controller
{
    //
    public function index()
    {
        return response()->json(vuelo::all());
    }
}
