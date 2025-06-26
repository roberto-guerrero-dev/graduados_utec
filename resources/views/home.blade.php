@extends('layouts.app')

@section('title', 'Inicio')
@section('content')
<div class="container bg-white" >
    <div class="row">
        <div class="col-12 img-fluid d-flex justify-content-center user-select-none">
            <img src="{{ asset('img/logo-institucional-utec.jpeg') }}" alt="Logo" class="img-fluid user-select-none" style="width: 80%; height: auto;">
        </div>
    </div>
    <h1 class="display-6 text-center">Sistema de Administración de Graduados de Carreras Técnicas</h1>
    <div class="row mt-5 justify-content-center">
        <div class="col-md-3 mb-4">
            <div class="card text-center shadow h-100" style="background-color: #F2D7D9;">
                <div class="card-body">
                    <i class="fas fa-user-graduate fa-4x mb-3 opacity-75" style="color: var(--bg-primary-custom)"></i>
                    <h5 class="card-title" style="color: var(--bg-primary-custom)">Graduados</h5>
                    <span class="h2 d-block" style="color: var(--bg-primary-custom)">{{ $totalGraduados }}</span>
                    <p class="card-text" style="color: var(--bg-primary-custom)">Gestiona la información de los graduados.</p>
                    <a href="{{ url('/graduados/form') }}" class="" style="color: var(--bg-primary-custom)">Ver Graduados</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center shadow h-100" style="background-color: #FFF0E6;">
                <div class="card-body">
                    <i class="fas fa-building-columns fa-4x mb-3 opacity-75" style="color: var(--bg-primary-custom)"></i>
                    <h5 class="card-title" style="color: var(--bg-primary-custom)">Facultades</h5>
                    <span class="h2 d-block" style="color: var(--bg-primary-custom)">{{ $totalFacultades }}</span>
                    <p class="card-text" style="color: var(--bg-primary-custom)">Administra las facultades disponibles.</p>
                    <a href="{{ url('/facultades') }}" class="" style="color: var(--bg-primary-custom)">Ver Facultades</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center shadow h-100" style="background-color: #D8C7D9;">
                <div class="card-body">
                    <i class="fas fa-book-open fa-4x mb-3 opacity-75" style="color: var(--bg-primary-custom)"></i>
                    <h5 class="card-title" style="color: var(--bg-primary-custom)">Carreras</h5>
                    <span class="h2 d-block" style="color: var(--bg-primary-custom)">{{ $totalCarreras }}</span>
                    <p class="card-text" style="color: var(--bg-primary-custom)">Administra las carreras técnicas disponibles.</p>
                    <a href="{{ url('/carreras') }}" class="" style="color: var(--bg-primary-custom)">Ver Carreras</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center shadow h-100" style="background-color: #c8d6e5;">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-4x mb-3 opacity-75" style="color: var(--bg-primary-custom)"></i>
                    <h5 class="card-title" style="color: var(--bg-primary-custom)">Reportes</h5>
                    <p class="card-text" style="color: var(--bg-primary-custom)">Consulta reportes.</p>
                    <a href="{{ url('/graduados/reporte') }}" class="" style="color: var(--bg-primary-custom)">Ver Reportes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
