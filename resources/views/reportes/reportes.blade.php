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
                                    <option value="presencial">Presencial</option>
                                    <option value="virtual">Virtual</option>
                                    <option value="semipresencial">Semipresencial</option>
                                </select>
                            </div>

                            {{-- Botón de Búsqueda --}}
                            <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn bg-primary-custom btn-sm fw-bold">
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
             {{-- Aquí podrías agregar una sección para la paginación si fuera necesario --}}
         </div>
     </div>
        </div>
     </div>
 </div>
 @endsection

@section('scripts')
<script>
    $(document).ready(function() {
        cargarTabla();
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
</script>
@endsection