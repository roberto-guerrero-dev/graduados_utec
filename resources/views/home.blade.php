@extends('layouts.app')

@section('content')
<div class="container bg-white mt-4" style="border-radius: 10px; padding: 20px; box-shadow: 0 0 40px #5E0022">
    <div class="row">
        <div class="col-12 img-fluid d-flex justify-content-center user-select-none">
            <img src="{{ asset('img/logo-institucional-utec.jpeg') }}" alt="Logo" class="img-fluid user-select-none" style="max-width: 100%; height: auto;">
        </div>
    </div>
    <h1 class="display-5 text-center">Sistema de Administración de Graduados de Carreras Técnicas</h1>
</div>
@endsection
