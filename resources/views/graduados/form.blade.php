@extends('layouts.app')

@section('title', 'Registrar Graduado en Carrera')

@section('content')
<div class="container bg-light mt-4">
    <h5>Registrar Graduado en una Carrera</h5>
    <div class="d-flex justify-content-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#graduadoModal">
            Registrar Graduado
        </button>
    </div>
    <div class="table-responsive">
        <table id="tablaGraduadosCarreras" class="table table-striped table-hover table-bordered" style="width:100%">
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
    <tbody>
        <!-- Los datos se cargarán mediante DataTables --> 
    </tbody>
</table>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="graduadoModal" tabindex="-1" aria-labelledby="graduadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="graduadoModalLabel">Registrar Graduado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="formGraduadoCarrera">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Carnet</label>
                        <input type="text" name="carnet_graduado" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Nombre</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Apellido</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Género</label>
                        <select name="genero" id="genero" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Correos</label>
                        <select name="correos[]" class="form-select correos-select" multiple required>
                                <option value=""></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Teléfonos</label>
                        <select name="telefonos[]" class="form-select telefonos-select" multiple required>
                                <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Carrera</label>
                        <select name="codigo_carrera" class="form-select" required>
                        <option value="">Seleccione carrera</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->codigo_carrera }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Fecha Graduación</label>
                        <input type="date" name="fecha_graduacion" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Ciclo Graduación</label>
                        <input type="text" name="ciclo_graduacion" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        Swal.fire('Esta es una prueba', '¡Hola, mundo!', 'success');
        cargarTabla(); // Cargar la tabla al inicio

        $('.correos-select, .telefonos-select').select2({
            dropdownParent: $('#graduadoModal'),
            tags: true,
            tokenSeparators: [',', ' '],
            placeholder: 'Seleccione opciones',
            width: '100%'
        });

        $('#formGraduadoCarrera').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("graduados.storeFull") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    alert('Graduado registrado correctamente');
                    $('#formGraduadoCarrera')[0].reset();
                    $('.correos-select, .telefonos-select').val(null).trigger('change');
                },
                error: function (response) {
                    alert('Error al registrar el graduado: ' + response.responseJSON.message);
                }
            });
        });

        function cargarTabla() {
            $('#tablaGraduadosCarreras').DataTable({
                processing: true,
                destroy: true,
                responsive: true,
                ajax: '/graduados-carreras/data',
                columns: [
                    { data: 'nombre' },
                    { data: 'carrera' },
                    { data: 'facultad' },
                    { data: 'fecha_graduacion' },
                    { data: 'ciclo_graduacion', width: '100px' },
                    { data: 'telefono' },
                    { data: 'correo' }
                ]
            });

            
        }
    });
</script>
@endsection
