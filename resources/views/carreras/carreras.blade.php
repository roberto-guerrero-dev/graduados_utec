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
                            <th>Acciones</th>
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
                <input type="number" class="form-control form-control-sm mb-2" name="codigo_carrera" placeholder="Codigo carrera">
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
                <select name="id_facultad" class="form-select form-select-sm mb-2" required>
                    <option value="">Seleccione facultad</option>   
                    @foreach($facultades as $facultad)
                                <option value="{{ $facultad->id_facultad }}">{{ $facultad->nombre_facultad }}</option>
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
        let id = $(this).attr('data-id');

        let method = id ? 'PUT' : 'POST';
        let url = id ? `/carreras/${id}` : '/carreras';

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
                { data: 'id_facultad' },
                {
                    data: null,
                    width: '80px',
                    render: function(data) {
                        return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editarCarrera(${data.id_carrera})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarCarrera(${data.id_carrera})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        `;
                    }
                }
            ]
        });
    }
});

function editarCarrera(id) {
    $.ajax({
        url: `/carreras/${id}`,
        method: 'GET',
        success: function(data) {
            $('#modalLabel').text('Editar Carrera');
            $('#formCarreras').attr('data-id', id);
            $('input[name="codigo_carrera"]').val(data.codigo_carrera);
            $('input[name="nombre"]').val(data.nombre);
            $('input[name="modalidad"]').val(data.modalidad);
            $('select[name="id_facultad"]').val(data.id_facultad);
            $('#modalCarreras').modal('show');
        },
        error: function(err) {
            alert('Error al cargar los datos de la carrera');
        }
    });
}

function eliminarCarrera(id) {
    if (confirm('¿Estás seguro de eliminar esta carrera?')) {
        $.ajax({
            url: `/carreras/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                location.reload(); // recargar tabla
            },
            error: function(err) {
                alert('Error al eliminar la carrera');
            }
        });
    }
}
</script>
@endsection