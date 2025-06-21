@extends('layouts.app')

@section('title', 'Registrar Graduado en Carrera')

@section('content')
    <div class="container bg-light mt-4">
        <div class="row">
            <h5 style="color: var(--bg-primary-custom);" class="mt-3">Registrar Graduado en una Carrera</h5>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-end mb-3">
                <!-- Button trigger modal -->
            <button type="button" class="btn bg-primary-custom btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#graduadoModal">
                Registrar Graduado
            </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
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
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="graduadoModal" tabindex="-1" aria-labelledby="graduadoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formGraduadoCarrera">
                @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary-custom">
                    <h5 class="modal-title" id="graduadoModalLabel">Registrar Graduado</h5>
                    <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Carnet</label>
                                <input type="text" name="carnet_graduado" class="form-control form-control-sm" >
                            </div>
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input type="text" name="nombres" class="form-control form-control-sm" >
                            </div>
                            <div class="col-md-4">
                                <label>Apellido</label>
                                <input type="text" name="apellidos" class="form-control form-control-sm" >
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Género</label>
                                <select name="genero" id="genero" class="form-select form-select-sm" >
                                    <option value="">Seleccione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Correos</label>
                                <select name="correos[]" class="form-select form-select-sm correos-select" multiple  style="width: 100%;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Teléfonos</label>
                                <select name="telefonos[]" class="form-select form-select-sm telefonos-select" multiple  style="width: 100%;">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Carrera</label>
                                <select name="codigo_carrera" class="form-select form-select-sm" >
                                    <option value="">Seleccione carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->codigo_carrera }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Graduación</label>
                                <input type="date" name="fecha_graduacion" class="form-control form-control-sm" >
                            </div>
                            <div class="col-md-3">
                                <label>Ciclo Graduación</label>
                                <input type="text" name="ciclo_graduacion" class="form-control form-control-sm" id="ciclo" >
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary-custom btn-sm fw-bold">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            cargarTabla(); // Cargar la tabla al inicio

            $('.correos-select, .telefonos-select').select2({
                theme: 'bootstrap-5',
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                dropdownParent: $('#graduadoModal'),
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Seleccione opciones',
                width: '100%'
            });

            $('#formGraduadoCarrera').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route('graduados.storeFull') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert('Graduado registrado correctamente');
                        $('#formGraduadoCarrera')[0].reset();
                        $('.correos-select, .telefonos-select').val(null).trigger('change');
                    },
                    error: function(response) {
                        console.log(JSON.stringify(response));
                        customSwal.showAlert('Complete todos los campos','', '', 'OK','bg-primary-custom', 'info');
                            
                    }
                });
            });

            function cargarTabla() {
                $('#tablaGraduadosCarreras').DataTable({
                    processing: true,
                    destroy: true,
                    responsive: true,
                    ajax: '/graduados-carreras/data',
                    columns: [{
                            data: 'nombre'
                        },
                        {
                            data: 'carrera'
                        },
                        {
                            data: 'facultad'
                        },
                        {
                            data: 'fecha_graduacion'
                        },
                        {
                            data: 'ciclo_graduacion',
                            width: '100px'
                        },
                        {
                            data: 'telefonos'
                        },
                        {
                            data: 'correos'
                        }
                    ]
                });

            }

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;
            const currentYear = currentDate.getFullYear();
            const currentCiclo = `${currentMonth  < 7 ? '01' : '02'}-${currentYear}`;
            const dynamicPlaceholders = [
                { selector: '#ciclo', placeholder: 'Ej. ' + currentCiclo }
            ];
            setDynamicPlaceholder(dynamicPlaceholders);

            function setDynamicPlaceholder(selectorsArray) {
                if (Array.isArray(selectorsArray) && selectorsArray.length > 0) {
                    selectorsArray.forEach(s => {
                        $(s.selector).attr('placeholder', s.placeholder);
                    });
                } else {
                    console.error('Invalid input: Expected an array of selectors.');
                }
            }
        });
    </script>
@endsection
