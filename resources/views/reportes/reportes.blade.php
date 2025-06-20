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

                            {{-- Filtro por Año de Graduación --}}
                            <div class="col-md-3">
                                <label for="anio_graduacion" class="form-label">Año de Graduación:</label>
                                <select class="form-select form-select-sm" id="anio_graduacion" name="anio_graduacion">
                                    <option value="">Seleccione un año</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    {{-- Agrega más años estáticos según sea necesario --}}
                                </select>
                            </div>

                            {{-- Filtro por Modalidad --}}
                            <div class="col-md-3">
                                <label for="modalidad" class="form-label">Modalidad:</label>
                                <select class="form-select form-select-sm" id="modalidad" name="modalidad">
                                    <option value="">Seleccione una modalidad</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="virtual">Virtual</option>
                                    <option value="semipresencial">Semipresencial</option>
                                </select>
                            </div>

                            {{-- Filtro por Ciclo de Graduación --}}
                            <div class="col-md-3">
                                <label for="ciclo_graduacion" class="form-label">Ciclo de Graduación:</label>
                                <select class="form-select form-select-sm" id="ciclo_graduacion" name="ciclo_graduacion">
                                    <option value="">Seleccione un ciclo</option>
                                    <option value="1">Ciclo 1</option>
                                    <option value="2">Ciclo 2</option>
                                    <option value="3">Ciclo 3</option>
                                    {{-- Agrega más ciclos estáticos si es necesario --}}
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
                 <table class="table table-striped table-hover align-middle">
                     <thead>
                         <tr>
                             <th scope="col">#</th>
                             <th scope="col">Nombre Completo</th>
                             <th scope="col">Carnet</th>
                             <th scope="col">Carrera</th>
                             <th scope="col">Fecha Graduación</th>
                             <th scope="col">Año Graduación</th>
                             <th scope="col">Modalidad</th>
                             <th scope="col">Ciclo Graduación</th>
                         </tr>
                     </thead>
                     <tbody>
                         <tr>
                             <th scope="row">1</th>
                             <td>Ejemplo Nombre 1 Ejemplo Apellido 1</td>
                             <td>CARNET001</td>
                             <td>Ingeniería de Sistemas</td>
                             <td>20/05/2023</td>
                             <td>2023</td>
                             <td>Presencial</td>
                             <td>2</td>
                         </tr>
                         <tr>
                             <th scope="row">2</th>
                             <td>Ejemplo Nombre 2 Ejemplo Apellido 2</td>
                             <td>CARNET002</td>
                             <td>Licenciatura en Administración de Empresas</td>
                             <td>15/11/2022</td>
                             <td>2022</td>
                             <td>Virtual</td>
                             <td>3</td>
                         </tr>
                         <tr>
                             <th scope="row">3</th>
                             <td>Ejemplo Nombre 3 Ejemplo Apellido 3</td>
                             <td>CARNET003</td>
                             <td>Arquitectura</td>
                             <td>01/03/2023</td>
                             <td>2023</td>
                             <td>Semipresencial</td>
                             <td>1</td>
                         </tr>
                         {{-- Agrega más filas de ejemplo estáticas si lo deseas --}}
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