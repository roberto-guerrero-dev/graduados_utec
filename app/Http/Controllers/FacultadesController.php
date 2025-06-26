<?php

namespace App\Http\Controllers;

use App\Models\Facultades;
use Illuminate\Http\Request;

class FacultadesController extends Controller
{
    public function index() {
        $facultades = Facultades::all();
        return view('facultades.facultades', compact('facultades'));
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['activo'] = 1;

        $facultad = Facultades::create($data);

        return response()->json($facultad);
    }

    public function edit($id) {
        return response()->json(Facultades::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $facultad = Facultades::findOrFail($id);
        $facultad->update($request->all());
        return response()->json($facultad);
    }

    public function destroy($id)
    {
        $facultad = Facultades::findOrFail($id);

        if ($facultad) {
            $facultad->activo = 0;
            $facultad->save();
            return response()->json(['success' => true, 'message' => 'Facultad desactivada correctamente.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Facultad no encontrada'], 404);
        }
    }

    public function show($id) {
        return response()->json(Facultades::findOrFail($id));
    }

    public function data()
    {
        $facultades = Facultades::where('activo', '!=', 0)->get();
        return response()->json(['data' => $facultades]);
    }
}
