@extends('layouts.app')

@section('title', 'Registrar Graduado en Carrera')

@section('content')
<div class="container bg-light mt-4">
    <h5>Registrar Usuario</h5>
    <div class="d-flex justify-content-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#usuarioModal">
            Registrar Usuario
        </button>
    </div>
    <table id="tablaGraduadosCarreras" class="display table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Carrera</th>
            <th>Facultad</th>
            <th>Fecha Graduación</th>
            <th>Ciclo</th>
            <th>Teléfono</th>
            <th>Correo</th>
        </tr>
    </thead>
</table>
</div>



<!-- Modal -->
<div class="modal fade" id="usuarioModal" tabindex="-1" aria-labelledby="usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="graduadoModalLabel">Registrar Graduado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email">Correo:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Registrar</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        cargarTabla(); // Cargar la tabla al inicio

        $('#formUsuario').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("graduados.storeFull") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert('Usuario registrado correctamente');
                    $('#formUsuario')[0].reset();
                },
                error: function () {
                    alert('Error al guardar');
                }
            });
        });

        function cargarTabla() {
            $('#tablaGraduadosCarreras').DataTable({
                processing: true,
                destroy: true,
                ajax: '/graduados-carreras/data',
                columns: [
                    { data: 'nombre' },
                    { data: 'carrera' },
                    { data: 'facultad' },
                    { data: 'fecha_graduacion' },
                    { data: 'ciclo_graduacion' },
                    { data: 'telefono' },
                    { data: 'correo' }
                ]
            });
        }
    });
</script>
@endsection
