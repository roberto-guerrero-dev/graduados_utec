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
        $data = $request->all();
        $data['activo'] = 1; // Asumimos que la carrera está activa
        $carrera = Carreras::create($data);
        return response()->json($carrera);
    }

    public function edit($id) {
        return response()->json(Carreras::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $carreras = Carreras::findOrFail($id);
        $carreras->update($request->all());
        return response()->json($carreras);
    }

    public function destroy($id) {
        $carrera = Carreras::findOrFail($id);
        if ($carrera) {
            $carrera->activo = 0; // Desactivamos la carrera en lugar de eliminarla
            $carrera->save();
            return response()->json(['success' => true, 'message' => 'Carrera desactivada correctamente.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Carrera no encontrada'], 404);
        }
    }

    public function show($id) {
        return response()->json(Carreras::findOrFail($id));
    }

    public function data()
    {
        $carreras = Carreras::all(); // Asegúrate de usar el modelo correcto
        return response()->json(['data' => $carreras]);
    }
}
