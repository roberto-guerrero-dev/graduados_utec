<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GraduadosCarreras;
use App\Models\Graduados;
use App\Models\Correos;
use App\Models\Telefonos;
use App\Models\Carreras;
use App\Models\VGraduadosCarreras;
use App\Models\Facultades;
use Illuminate\Support\Facades\DB;

class GraduadosController extends Controller
{
    public function index()
    {
        $graduados = Graduados::all();
        return view('graduados.index', compact('graduados'));
    }

    public function buscarGraduados(Request $request)
    {
        $data = [
            $request->filled('fecha_inicio') ? $request->input('fecha_inicio') : null,
            $request->filled('fecha_fin') ? $request->input('fecha_fin') : null,
            $request->filled('modalidad') ? $request->input('modalidad') : null,
            $request->filled('genero') ? $request->input('genero') : null,
            $request->filled('carrera') ? $request->input('carrera') : null,
            $request->filled('facultad') ? $request->input('facultad') : null,
        ];

        $resultados = DB::select('CALL SP_BuscarGraduados(?, ?, ?, ?, ?, ?)', $data);

        return response()->json(['data' => $resultados]); // DataTables espera la key "data"
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
        $carreras = Carreras::all();
        $facultades = Facultades::all();
        $graduados = VGraduadosCarreras::all();
        return view('reportes.reportes', compact('carreras', 'facultades', 'graduados'));
    }

    public function storeFull(Request $request)
    {
        try {
            $validated = $request->validate([
                'carnet_graduado' => 'required|string|unique:graduados,carnet_graduado',
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'genero' => 'required|string|in:Masculino,Femenino',
                'id_carrera' => 'required|int|exists:carreras,id_carrera',
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
                'activo' => 1, // Asumimos que el graduado está activo al momento de crear
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
                'id_carrera' => $validated['id_carrera'],
                'fecha_graduacion' => $validated['fecha_graduacion'],
                'ciclo_graduacion' => $validated['ciclo_graduacion'],
            ]);

            return response()->json(['success' => true, 'message' => 'Graduado creado correctamente.'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nombres' => 'required|string',
                'apellidos' => 'required|string',
                'genero' => 'required|string',
                'codigo_carrera' => 'required|string',
                'fecha_graduacion' => 'required|date',
                'ciclo_graduacion' => 'required|string',
                'correos' => 'required|array',
                'telefonos' => 'required|array',
            ]);

            $graduadoCarrera = GraduadosCarreras::findOrFail($id);
            $graduado = Graduados::where('carnet_graduado', $graduadoCarrera->carnet_graduado)->first();

            $graduado->update([
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'genero' => $validated['genero'],
            ]);

            $graduadoCarrera->update([
                'codigo_carrera' => $validated['codigo_carrera'],
                'fecha_graduacion' => $validated['fecha_graduacion'],
                'ciclo_graduacion' => $validated['ciclo_graduacion'],
            ]);

            // Actualizar correos y teléfonos
            Correos::where('carnet_graduado', $graduadoCarrera->carnet_graduado)->delete();
            foreach ($validated['correos'] as $correo) {
                Correos::create([
                    'carnet_graduado' => $graduadoCarrera->carnet_graduado,
                    'correo' => $correo,
                ]);
            }

            Telefonos::where('carnet_graduado', $graduadoCarrera->carnet_graduado)->delete();
            foreach ($validated['telefonos'] as $telefono) {
                Telefonos::create([
                    'carnet_graduado' => $graduadoCarrera->carnet_graduado,
                    'telefono' => $telefono,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Graduado actualizado correctamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $graduadoCarrera = GraduadosCarreras::findOrFail($id);
        $graduado = Graduados::where('carnet_graduado', $graduadoCarrera->carnet_graduado)->first();

        if ($graduado) {
            $graduado->activo = 0;
            $graduado->save();
            return response()->json(['success' => true, 'message' => 'Graduado desactivado correctamente.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Graduado no encontrado'], 404);
        }
    }


    public function show($id)
    {
        $gc = GraduadosCarreras::findOrFail($id);
        $g = Graduados::where('carnet_graduado', $gc->carnet_graduado)->first();

        return response()->json([
            'carnet_graduado' => $g->carnet_graduado,
            'nombres' => $g->nombres,
            'apellidos' => $g->apellidos,
            'genero' => $g->genero,
            'codigo_carrera' => $gc->codigo_carrera,
            'fecha_graduacion' => $gc->fecha_graduacion,
            'ciclo_graduacion' => $gc->ciclo_graduacion,
            'correos' => Correos::where('carnet_graduado', $g->carnet_graduado)->pluck('correo'),
            'telefonos' => Telefonos::where('carnet_graduado', $g->carnet_graduado)->pluck('telefono'),
        ]);
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

    // public function update(Request $request, $id)
    // {
    //     $graduado = Graduados::findOrFail($id);
    //     $graduado->update($request->all());
    //     return response()->json(['success' => true, 'data' => $graduado]);
    // }

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
