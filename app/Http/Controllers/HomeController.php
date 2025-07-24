<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Graduados;
use App\Models\Carreras;
use App\Models\Facultades;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalGraduados = Graduados::where('activo', '!=', 0)->count();
        $totalCarreras = Carreras::where('activo', '!=', 0)->count();
        $totalFacultades = Facultades::where('activo', '!=', 0)->count();
        return view('home', compact('totalGraduados', 'totalCarreras', 'totalFacultades'));
    }
}
