<?php

namespace App\Http\Controllers;

use App\Models\Facultades;
use Illuminate\Http\Request;

class FacultadesController extends Controller
{
    public function index() {
        return response()->json(Facultades::all());
    }

    public function store(Request $request) {
        return response()->json(Facultades::create($request->all()));
    }

    public function edit($id) {
        return response()->json(Facultades::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $facultad = Facultades::findOrFail($id);
        $facultad->update($request->all());
        return response()->json($facultad);
    }

    public function destroy($id) {
        return response()->json(Facultades::destroy($id));
    }
}
