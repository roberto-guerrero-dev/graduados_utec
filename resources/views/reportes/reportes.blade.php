@extends('layouts.app') {{-- Asume que tienes un layout principal llamado app.blade.php --}}

 @section('content')
 <div class="container">
     <div class="row">
        <h5 class="mt-3" style="color: var(--bg-primary-custom)">Generación de Reportes</h5>
     </div>

     <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary-custom text-white">
                    <h5 class="mb-0">Filtros de Búsqueda</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="GET">
                        <div class="row g-3">
                            {{-- Filtro por Fecha (Rango) --}}
                            <div class="col-md-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_inicio" name="fecha_inicio">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_fin" name="fecha_fin">
                            </div>

                            {{-- Filtro por Modalidad --}}
                            <div class="col-md-3">
                                <label for="modalidad" class="form-label">Modalidad :</label>
                                <select class="form-select form-select-sm" id="modalidad" name="modalidad">
                                    <option value="">Seleccione una modalidad</option>
                                    <option value="Presencial">Presencial</option>
                                    <option value="Virtual">Virtual</option>
                                    <option value="semipresencial">Semipresencial</option>
                                </select>
                            </div>

                            {{-- Filtro por Genero --}}
                            <div class="col-md-3">
                                <label for="genero" class="form-label">Género:</label>
                                <select class="form-select form-select-sm" id="genero" name="genero">
                                    <option value="">Seleccione un género</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>

                            {{-- Filtro por Carrera --}}
                            <div class="col-md-3">
                                <label for="carrera" class="form-label">Carrera:</label>
                                <select class="form-select form-select-sm" id="carrera" name="carrera">
                                    <option value="">Seleccione una carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->nombre }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filtro por Facultad --}}
                            <div class="col-md-3">
                                <label for="facultad" class="form-label">Facultad:</label>
                                <select class="form-select form-select-sm" id="facultad" name="facultad">
                                    <option value="">Seleccione una facultad</option>
                                    @foreach ($facultades as $facultad)
                                        <option value="{{ $facultad->nombre_facultad }}">{{ $facultad->nombre_facultad }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Botón de Búsqueda --}}
                            <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn bg-primary-custom btn-sm fw-bold" id="btnBuscar">
                                    <i class="fa-solid fa-filter"></i> Aplicar Filtros
                                </button>
                                <button type="reset" class="btn btn-secondary btn-sm fw-bold">
                                    <i class="fa-solid fa-xmark"></i> Limpiar Filtros
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

     <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
         <div class="card-header bg-primary-custom text-white">
             <h5 class="mb-0">Resultados del Reporte</h5>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table id="tablaGraduadosCarreras" class="table table-striped table-hover table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Genero</th>
                                <th>Carrera</th>
                                <th>Facultad</th>
                                <th>Modalidad</th>
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
             {{-- Aquí podrías agregar una sección para la paginación si fuera necesario --}}
         </div>
     </div>
        </div>
     </div>
 </div>
 @endsection

@section('scripts')
<script>
    let tabla;
    $(document).ready(function() {
        // cargarTabla();
        tabla = $('#tablaGraduadosCarreras').DataTable({
            processing: true,
            serverSide: false,
            destroy: true,
            responsive: true,
            language: {
                url: '/assets/lang/es-ES.json'
            },
            ajax: {
                url: '{{ route("graduados.buscar") }}',
                type: 'POST',
                data: function (d) {
                    return {
                        _token: '{{ csrf_token() }}',
                        fecha_inicio: $('#fecha_inicio').val(),
                        fecha_fin: $('#fecha_fin').val(),
                        modalidad: $('#modalidad').val(),
                        genero: $('#genero').val(),
                        carrera: $('#carrera').val(),    // si agregas el campo
                        facultad: $('#facultad').val()   // si agregas el campo
                    };
                }
            },
            columns: [
                { data: 'nombre' },
                { data: 'genero' },
                { data: 'carrera' },
                { data: 'facultad' },
                { data: 'modalidad' },
                { data: 'fecha_graduacion' },
                { data: 'ciclo_graduacion' },
                { data: 'telefonos' },
                { data: 'correos' }
            ]
        });

        $('#btnBuscar').on('click', function (e) {
            e.preventDefault();
            tabla.ajax.reload(); // recarga el DataTable con nuevos filtros
        });

        // (opcional) para limpiar filtros
        $('form')[0].addEventListener('reset', function () {
            setTimeout(() => tabla.ajax.reload(), 100);
        });
    });
    // function cargarTabla() {
    //             $('#tablaGraduadosCarreras').DataTable({
    //                 processing: true,
    //                 destroy: true,
    //                 responsive: true,
    //                 language: {
    //                     url: '/assets/lang/es-ES.json'
    //                 },
    //                 ajax: '/graduados-carreras/data',
    //                 columns: [{
    //                         data: 'nombre'
    //                     },
    //                     {
    //                         data: 'genero'
    //                     },
    //                     {
    //                         data: 'carrera'
    //                     },
    //                     {
    //                         data: 'facultad'
    //                     },
    //                     {
    //                         data: 'modalidad'
    //                     },
    //                     {
    //                         data: 'fecha_graduacion'
    //                     },
    //                     {
    //                         data: 'ciclo_graduacion',
    //                         width: '100px'
    //                     },
    //                     {
    //                         data: 'telefonos'
    //                     },
    //                     {
    //                         data: 'correos'
    //                     }
    //                 ]
    //             });

    //         }
</script>
@endsection