@extends('layouts.app')

@section('title', 'Facultades')
@section('content')
<div class="container bg-light mt-4">
    <div class="row">
        <h5 class="mt-3" style="color: var(--bg-primary-custom)">Lista de Facultades</h5>
    </div>
    <div class="row">
        <div class="d-flex justify-content-end">
        <button class="btn bg-primary-custom btn-sm mb-3 fw-bold" id="btnAgregar">Agregar Facultad</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="">
                <table class="table table-striped table-hover table-bordered" id="tablaFacultades">
                    <thead>
                        <tr>
                            <th>Codigo Facultad</th>
                            <th>Nombre Facultad</th>
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
<div class="modal fade" id="modalFacultades" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="formFacultades">
      @csrf
      <input type="hidden" id="graduado_id" name="id">
      <div class="modal-content">
        <div class="modal-header bg-primary-custom">
          <h5 class="modal-title" id="modalLabel">Agregar Facultad</h5>
          <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Codigo</label>
                <input class="form-control form-control-sm mb-2" name="codigo_facultad" placeholder="Codigo">
            </div>
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Nombre</label>
                <input class="form-control form-control-sm mb-2" name="nombre_facultad" placeholder="Nombre">
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
        $('#modalFacultades').modal('show');
    });

    // Guardar o actualizar
    $('#formFacultades').submit(function(e) {
        e.preventDefault();
        let id = $(this).attr('data-id');
        let method = id ? 'PUT' : 'POST';
        let url = id ? `/facultades/${id}` : '/facultades';

        let codigo = $('input[name="codigo_facultad"]').val().trim();
        let nombre = $('input[name="nombre_facultad"]').val().trim();

        if (!codigo) {
            customSwal.showAlert('El campo "Codigo" es obligatorio', '', '', 'Ok', 'bg-primary-custom', 'warning');
            return;
        }
        if (!nombre) {
            customSwal.showAlert('El campo "Nombre" es obligatorio', '', '', 'Ok', 'bg-primary-custom', 'warning');
            return;
        }

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function(res) {
                $('#modalFacultades').modal('hide');
                $('input[name="codigo_facultad"]').val('');
                $('input[name="nombre_facultad"]').val('');
                $('#formFacultades').removeAttr('data-id'); // Limpiar el atributo data-id
                customSwal.showAlert(id ? 'Se actualizó la facultad' : 'Se guardó la facultad', '', '', 'Ok',
                        'bg-primary-custom', 'success');
                cargarTabla(); // recargar tabla
            },
            error: function(err) {
                customSwal.showAlert(err.responseText, '', '', 'Ok',
                        'bg-primary-custom', 'error');
            }
        });
    });


    
});
function cargarTabla() {
        
        $('#tablaFacultades').DataTable({
            destroy: true,
            processing: true,
            responsive: true,
            language: {
                url: '/assets/lang/es-ES.json'
            },
            ajax: '/facultades/data',
            columns: [
                { data: 'codigo_facultad' },
                { data: 'nombre_facultad' },
                {
                    data: null,
                    width: '80px',
                    render: function(data) {
                        return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" onclick="editarFacultad(${data.id_facultad})"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarFacultad(${data.id_facultad})"><i class="fa-solid fa-trash"></i></button>
                        </div>
                        `;
                    }
                }
            ]
        });
    }

$('#modalFacultades').on('hidden.bs.modal', function () {
    $('#formFacultades').removeAttr('data-id'); // Limpiar el atributo data-id
    $('input[name="codigo_facultad"]').val('');
    $('input[name="nombre_facultad"]').val('');
    $('#modalLabel').text('Agregar Facultad'); // Cambiar el título del modal
});

function editarFacultad(id) {
    $.ajax({
        url: `/facultades/${id}`,
        method: 'GET',
        success: function(data) {
            $('input[name="codigo_facultad"]').val(data.codigo_facultad);
            $('input[name="nombre_facultad"]').val(data.nombre_facultad);
            $('#formFacultades').attr('data-id', id);
            $('#modalLabel').text('Editar Facultad'); // Cambiar el título del modal
            $('#modalFacultades').modal('show');
        },
        error: function(err) {
            alert('Error al cargar los datos de la facultad');
        }
    });
}

function eliminarFacultad(id) {
    customSwal.showConfirm('¿Estás seguro de eliminar esta facultad?', '', '', 'Eliminar', 'bg-primary-custom', 'Cancelar', 'bg-secondary','', function() {
        $.ajax({
            url: `/facultades/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                cargarTabla(); // recargar tabla
                customSwal.showAlert('Se eliminó la facultad', '', '', 'Ok',
                        'bg-primary-custom', 'success');
            },
            error: function(err) {
                alert('Error al eliminar la facultad');
            }
        });
    });
}
</script>
@endsection