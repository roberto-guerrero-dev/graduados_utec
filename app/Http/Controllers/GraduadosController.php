<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graduados;

class GraduadosController extends Controller
{
    public function index()
    {
        $graduados = Graduados::all();
        return view('graduados.index', compact('graduados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carnet_graduado' => 'required|unique:graduados',
            'nombres' => 'required',
            'apellidos' => 'required',
            'genero' => 'required',
        ]);

        $graduado = Graduados::create($request->all());
        return response()->json(['success' => true, 'data' => $graduado]);
    }

    public function edit($id)
    {
        $graduado = Graduados::findOrFail($id);
        return response()->json($graduado);
    }

    public function update(Request $request, $id)
    {
        $graduado = Graduados::findOrFail($id);
        $graduado->update($request->all());
        return response()->json(['success' => true, 'data' => $graduado]);
    }

    public function destroy($id)
    {
        Graduados::destroy($id);
        return response()->json(['success' => true]);
    }
}
