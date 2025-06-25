<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GraduadosCarreras;
use App\Models\Graduados;
use App\Models\Correos;
use App\Models\Telefonos;
use App\Models\Carreras;
use App\Models\VGraduadosCarreras;

class GraduadosController extends Controller
{
    public function index()
    {
        $graduados = Graduados::all();
        return view('graduados.index', compact('graduados'));
    }

    public function createForm()
    {
        $carreras = Carreras::all();
        $correos = Correos::pluck('correo'); // solo los correos únicos
        $telefonos = Telefonos::pluck('telefono');

        return view('graduados.form', compact('carreras', 'correos', 'telefonos'));
    }

    public function reporteGraduados()
    {
        $graduados = VGraduadosCarreras::all();
        return view('reportes.reportes', compact('graduados'));
    }

    public function storeFull(Request $request)
    {
        try {
            $validated = $request->validate([
                'carnet_graduado' => 'required|string|unique:graduados,carnet_graduado',
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'genero' => 'required|string|in:Masculino,Femenino',
                'codigo_carrera' => 'required|string|exists:carreras,codigo_carrera',
                'fecha_graduacion' => 'required|date',
                'ciclo_graduacion' => 'required|string',
                'correos' => 'required|array',
                'telefonos' => 'required|array',
            ]);

            $graduado = Graduados::create([
                'carnet_graduado' => $validated['carnet_graduado'],
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'genero' => $validated['genero'],
            ]);

            foreach ($validated['correos'] as $correo) {
                Correos::create([
                    'carnet_graduado' => $validated['carnet_graduado'],
                    'correo' => $correo,
                ]);
            }

            foreach ($validated['telefonos'] as $telefono) {
                Telefonos::create([
                    'carnet_graduado' => $validated['carnet_graduado'],
                    'telefono' => $telefono,
                ]);
            }

            GraduadosCarreras::create([
                'carnet_graduado' => $validated['carnet_graduado'],
                'codigo_carrera' => $validated['codigo_carrera'],
                'fecha_graduacion' => $validated['fecha_graduacion'],
                'ciclo_graduacion' => $validated['ciclo_graduacion'],
            ]);

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $registro = GraduadosCarreras::findOrFail($id);
        $registro->delete(); // Esto solo marca como eliminado

        return response()->json(['success' => true, 'message' => 'Registro eliminado correctamente.']);
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

    // public function destroy($id)
    // {
    //     Graduados::destroy($id);
    //     return response()->json(['success' => true]);
    // }

    public function data()
    {
        $graduados = Graduados::all(); // Asegúrate de usar el modelo correcto
        return response()->json(['data' => $graduados]);
    }

}
