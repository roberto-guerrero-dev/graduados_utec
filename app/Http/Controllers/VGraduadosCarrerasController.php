<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VGraduadosCarreras;

class VGraduadosCarrerasController extends Controller
{
    public function data()
    {
        $data = VGraduadosCarreras::all();
        return response()->json(['data' => $data]);
    }
}
