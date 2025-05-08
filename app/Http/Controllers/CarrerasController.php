<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carreras; // Asegúrate de usar el modelo correcto
use App\Models\Facultades; // Asegúrate de usar el modelo correcto

class CarrerasController extends Controller
{
    public function index() {
        $carreras = Carreras::all();
        $facultades = Facultades::all();
        return view('carreras.carreras', compact('carreras', 'facultades'));
    }

    public function store(Request $request) {
        return response()->json(Carreras::create($request->all()));
    }

    public function edit($id) {
        return response()->json(Carreras::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $carreras = Carreras::findOrFail($id);
        $carreras->update($request->all());
        return response()->json($facultad);
    }

    public function destroy($id) {
        return response()->json(Carreras::destroy($id));
    }

    public function data()
    {
        $carreras = Carreras::all(); // Asegúrate de usar el modelo correcto
        return response()->json(['data' => $carreras]);
    }
}
