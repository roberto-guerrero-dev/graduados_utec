@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 150px;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Registrarse</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group mb-5">
                                <label for="user">Nombre</label>
                                <input type="text" name="name" id="user" class="form-control" required autofocus>
                            </div>
                            <div class="form-group mb-5">
                                <label for="password">Email</label>
                                <input type="email" name="email" id="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-5">
                                <label for="user">Contraseña</label>
                                <input type="password" name="password" id="user" class="form-control" required autofocus>
                            </div>
                            <div class="form-group mb-5">
                                <label for="password">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" id="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn w-100" style="background-color: #5E0022; color: white;">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection