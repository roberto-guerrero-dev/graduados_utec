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
                <button type="button" class="btn bg-primary-custom btn-sm fw-bold" data-bs-toggle="modal"
                    data-bs-target="#graduadoModal">
                    Registrar Graduado
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="tablaGraduadosCarreras" class="table table-striped table-hover table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Carrera</th>
                                <th>Facultad</th>
                                <th>Modalidad</th>
                                <th>Fecha Graduación</th>
                                <th>Ciclo</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Acciones</th>
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
                        <button type="reset" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Carnet (no debe llevar guiones ni espacios)</label>
                                <input type="text" name="carnet_graduado" class="form-control form-control-sm"
                                    placeholder="Ej. 2717932022">
                            </div>
                            <div class="col-md-4">
                                <label>Nombre</label>
                                <input type="text" name="nombres" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Apellido</label>
                                <input type="text" name="apellidos" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>Género</label>
                                <select name="genero" id="genero" class="form-select form-select-sm">
                                    <option value="">Seleccione</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Correos</label>
                                <select name="correos[]" class="form-select form-select-sm correos-select" multiple
                                    style="width: 100%;">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Teléfonos</label>
                                <select name="telefonos[]" class="form-select form-select-sm telefonos-select" multiple
                                    style="width: 100%;">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Carrera</label>
                                <select name="codigo_carrera" class="form-select form-select-sm">
                                    <option value="">Seleccione carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->codigo_carrera }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Fecha Graduación</label>
                                <input type="date" name="fecha_graduacion" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label>Ciclo Graduación</label>
                                <input type="text" name="ciclo_graduacion" class="form-control form-control-sm"
                                    id="ciclo">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-primary-custom btn-sm fw-bold">Guardar</button>
                        <button type="reset" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
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
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                dropdownParent: $('#graduadoModal'),
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: 'Seleccione opciones',
                width: '100%'
            });

            $('#formGraduadoCarrera').submit(function(e) {
                e.preventDefault();

                // Validación
                let camposVacios = false;

                // Recorre todos los inputs, selects y select2 requeridos dentro del formulario
                $('#formGraduadoCarrera')
                    .find('input:not([type=hidden]), select')
                    .each(function() {
                        if (!$(this).val() || $(this).val().length === 0) {
                            camposVacios = true;
                            return false; // rompe el .each
                        }
                    });

                if (camposVacios) {
                    customSwal.showAlert('Complete todos los campos antes de guardar', '', '', 'Ok',
                        'bg-primary-custom', 'warning');
                    return; // Detiene la ejecución
                }

                if ($('[name="ciclo_graduacion"]').hasClass('is-invalid')) {
                    customSwal.showAlert('El ciclo ingresado no es válido', '', '', 'Ok',
                        'bg-primary-custom', 'warning');
                    return; // Detiene la ejecución
                }

                let correos = $('.correos-select').val();
                let telefonos = $('.telefonos-select').val();
                if (!correosValidos(correos)) {
                    customSwal.showAlert('Uno o más correos no son válidos', '', '', 'Ok',
                        'bg-primary-custom', 'warning');
                    return; // Detiene la ejecución
                }

                if (!telefonosValidos(telefonos)) {
                    customSwal.showAlert('Uno o más teléfonos no son válidos', '', '', 'Ok',
                        'bg-primary-custom', 'warning');
                    return; // Detiene la ejecución
                }

                const fechaGraduacion = $('[name="fecha_graduacion"]').val();
                const fechaIngresada = new Date(fechaGraduacion);
                const hoy = new Date();
                hoy.setHours(0, 0, 0, 0);

                if (fechaIngresada > hoy) {
                    customSwal.showAlert('La fecha de graduación no puede ser futura', '', '', 'Ok',
                        'bg-primary-custom', 'warning');
                    return;
                }

                let id = $(this).attr('data-id');
                let url = id ? `/graduados-carreras/${id}` : '{{ route('graduados.storeFull') }}';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        customSwal.showAlert(response.message, '', '', 'Ok',
                            'bg-primary-custom', 'success');
                        $('#formGraduadoCarrera')[0].reset();
                        $('.correos-select, .telefonos-select').val(null).trigger('change');
                        $('#graduadoModal').modal('hide');
                        $('#formGraduadoCarrera').removeAttr('data-id');
                        $('#tablaGraduadosCarreras').DataTable().ajax.reload();
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Ocurrió un error. Verifica los datos.');
                    }
                });
            });


            function cargarTabla() {
                $('#tablaGraduadosCarreras').DataTable({
                    processing: true,
                    destroy: true,
                    responsive: true,
                    language: {
                        url: '/assets/lang/es-ES.json'
                    },
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
                            data: 'modalidad'
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
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                <div class="btn-group">
                                    <button class="btn btn-warning btn-sm" onclick="editarGraduado(${data.id})"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button class="btn btn-danger btn-sm" onclick="eliminarGraduado(${data.id})"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                `;
                            },
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

            }

            const currentDate = new Date();
            const currentMonth = currentDate.getMonth() + 1;
            const currentYear = currentDate.getFullYear();
            const currentCiclo = `${currentMonth  < 7 ? '01' : '02'}-${currentYear}`;
            const dynamicPlaceholders = [{
                selector: '#ciclo',
                placeholder: 'Ej. ' + currentCiclo
            }];
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

        function eliminarGraduado(id) {
            if (confirm('¿Estás seguro de eliminar este registro?')) {
                $.ajax({
                    url: '/graduados-carreras/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#tablaGraduadosCarreras').DataTable().ajax.reload();
                    },
                    error: function(err) {
                        alert('Error al eliminar');
                        console.log(err);
                    }
                });
            }
        }

        function editarGraduado(id) {
            $.get(`/graduados-carreras/${id}`, function(data) {
                // Llenar el formulario del modal con los datos recibidos
                $('[name="carnet_graduado"]').val(data.carnet_graduado).prop('disabled', true); // No se edita
                $('[name="nombres"]').val(data.nombres);
                $('[name="apellidos"]').val(data.apellidos);
                $('[name="genero"]').val(data.genero);
                $('[name="codigo_carrera"]').val(data.codigo_carrera);
                $('[name="fecha_graduacion"]').val(data.fecha_graduacion);
                $('[name="ciclo_graduacion"]').val(data.ciclo_graduacion);

                // Llenar Select2 - Correos
                let correosSelect = $('.correos-select');
                correosSelect.empty();
                data.correos.forEach(correo => {
                    let option = new Option(correo, correo, true, true);
                    correosSelect.append(option);
                });
                correosSelect.trigger('change');

                // Llenar Select2 - Teléfonos
                let telefonosSelect = $('.telefonos-select');
                telefonosSelect.empty();
                data.telefonos.forEach(telefono => {
                    let option = new Option(telefono, telefono, true, true);
                    telefonosSelect.append(option);
                });
                telefonosSelect.trigger('change');

                // Agregar un atributo al formulario para saber que es edición
                $('#formGraduadoCarrera').attr('data-id', id);
                $('#graduadoModal').modal('show');
            }).fail(function() {
                alert('Error al obtener los datos del graduado');
            });
        }

        $('#graduadoModal').on('hidden.bs.modal', function() {
            $('#formGraduadoCarrera')[0].reset();
            $('.correos-select, .telefonos-select').val(null).trigger('change');
            $('#formGraduadoCarrera').removeAttr('data-id');
            $('[name="carnet_graduado"]').prop('disabled', false); // Habilitar campo carnet
        });

        const cicloRegex = oRegEx.cicloRegEx();
        $('#ciclo').on('input', function() {
            let ciclo = $(this).val();
            if (cicloRegex.test(ciclo)) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        });

        function correosValidos(correos) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return correos.every(correo => emailRegex.test(correo));
        }

        function telefonosValidos(telefonos) {
            const regexSV = /^[267]\d{7}$/; // El Salvador
            const regexUS = /^\d{10}$/; // Estados Unidos

            return telefonos.every(num => regexSV.test(num) || regexUS.test(num));
        }
    </script>
@endsection
