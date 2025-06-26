@extends('layouts.login')

@section('title', 'Login')

@section('content')
<div class="container" style="margin-top: 150px;">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <img src="{{ asset('img/logo-institucional-utec.jpeg') }}" alt="Imagen Institucional" class="mb-3" style="width: 100%; height: auto;">
            <h4 class="text-center mb-4">Acceder al Sistema de Gestión de Graduados de Carreras Técnicas</h4>
            <div class="card">
                <div class="card-header text-center">
                    <i class="fa-solid fa-user fa-5x mb-3" style="color: #5E0022;"></i>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf
                        <div class="form-group mb-5">
                            <label for="user">Usuario</label>
                            <input type="text" name="email" id="user" class="form-control" required autofocus>
                        </div>
                        <div class="form-group mb-5">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn w-100" style="background-color: #5E0022; color: white;">Acceder <i class="fa-solid fa-arrow-up-from-bracket fa-rotate-90"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById('login-form');

        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Evita recarga

            const formData = new FormData(form);

            fetch("{{ route('login') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(async response => {
                if (response.ok) {
                    // Redirige si el login fue exitoso
                    window.location.href = "{{ url('/home') }}";
                } else {
                    const data = await response.json();
                    let mensaje = 'Credenciales incorrectas.';
                    if (data && data.message) {
                        mensaje = data.message;
                    }

                    customSwal.showAlert('Error de acceso', mensaje, '', 'Ok', 'bg-primary-custom', 'error');
                }
            })
            .catch(error => {
                console.error(error);
                customSwal.showAlert('Error de conexión', 'Algo salió mal en el servidor.', '', 'Ok', 'bg-primary-custom', 'error');
            });
        });
    });
</script>