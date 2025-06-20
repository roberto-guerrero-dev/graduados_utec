@extends('layouts.app')

@section('content')
<div class="container bg-light mt-4">
    <div class="row">
        <h5 class="mt-3" style="color: var(--bg-primary-custom)">Lista de Carreras</h5>
    </div>
    <div class="row">
        <div class="d-flex justify-content-end">
        <button class="btn bg-primary-custom btn-sm mb-3 fw-bold" id="btnAgregar">Agregar Carrera</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="">
                <table class="table table-striped table-hover table-bordered" id="tablaCarreras">
                    <thead>
                        <tr>
                            <th>Codigo Carrera</th>
                            <th>Nombre Carrera</th>
                            <th>Modalidad</th>
                            <th>Facultad</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCarreras" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="formCarreras">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary-custom">
          <h5 class="modal-title" id="modalLabel">Agregar Carrera</h5>
          <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Codigo</label>
                <input class="form-control form-control-sm mb-2" name="codigo_carrera" placeholder="Codigo carrera">
            </div>
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Nombre</label>
                <input class="form-control form-control-sm mb-2" name="nombre" placeholder="Nombre">
            </div>
          </div>
          <div class="row">
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Modalidad</label>
                <input class="form-control form-control-sm mb-2" name="modalidad" placeholder="modalidad">
            </div>
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Facultad</label>
                <select name="codigo_facultad" class="form-select form-select-sm mb-2" required>
                    <option value="">Seleccione facultad</option>   
                    @foreach($facultades as $facultad)
                                <option value="{{ $facultad->codigo_facultad }}">{{ $facultad->nombre_facultad }}</option>
                            @endforeach
                </select>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn bg-primary-custom btn-sm fw-bold">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    cargarTabla(); // Cargar la tabla al inicio
    // Agregar
    $('#btnAgregar').click(function() {
        $('#modalCarreras').modal('show');
    });

    // Guardar o actualizar
    $('#formCarreras').submit(function(e) {
        e.preventDefault();
        let method = 'POST';
        let url = '/carreras';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                location.reload(); // recargar tabla
            },
            error: function(err) {
                alert('Error al guardar' + err.responseText);
            }
        });
    });


    function cargarTabla() {
        
        $('#tablaCarreras').DataTable({
            destroy: true,
            processing: true,
            responsive: true,
            ajax: '/carreras/data',
            columns: [
                { data: 'codigo_carrera' },
                { data: 'nombre' },
                { data: 'modalidad' },
                { data: 'codigo_facultad' }
            ]
        });
    }
});
</script>
@endsection