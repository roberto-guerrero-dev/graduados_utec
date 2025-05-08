@extends('layouts.app')

@section('content')
<div class="container-fluid bg-light mt-4">
    <h5>Lista de Graduados</h5>
    <div class="row">
        <div class="d-flex justify-content-end">
        <button class="btn btn-primary btn-sm mb-3" id="btnAgregar">Agregar Graduado</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="">
                <table class="table table-bordered table-hover" id="tablaGraduados">
                    <thead>
                        <tr>
                            <th>Carnet</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Género</th>
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
<div class="modal fade" id="modalGraduado" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form id="formGraduado">
      @csrf
      <input type="hidden" id="graduado_id" name="id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Agregar Graduado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Carnet</label>
                <input class="form-control form-control-sm mb-2" name="carnet_graduado" placeholder="Carnet">
            </div>
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Genero</label>
                <select class="form-control form-control-sm mb-2" name="genero">
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Carnet</label>
                <input class="form-control form-control-sm mb-2" name="nombres" placeholder="Nombres">
            </div>
            <div class="col-6">
                <label class="col-form-label col-form-label-sm" for="">Carnet</label>
                <input class="form-control form-control-sm mb-2" name="apellidos" placeholder="Apellidos">
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
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
        $('#formGraduado')[0].reset();
        $('#graduado_id').val('');
        $('#modalLabel').text('Agregar Graduado');
        $('#modalGraduado').modal('show');
    });

    // Editar
    $('#tablaGraduados tbody').on('click', '.btnEditar', function() {
        let id = $(this).data('id');
        console.log(id);
        $.get(`/graduados/${id}/edit`, function(data) {
            $('[name="carnet_graduado"]').val(data.carnet_graduado);
            $('[name="nombres"]').val(data.nombres);
            $('[name="apellidos"]').val(data.apellidos);
            $('[name="genero"]').val(data.genero);
            $('#graduado_id').val(data.id_graduado);
            $('#modalLabel').text('Editar Graduado');
            $('#modalGraduado').modal('show');
        });
    });

    // Guardar o actualizar
    $('#formGraduado').submit(function(e) {
        e.preventDefault();
        let id = $('#graduado_id').val();
        let method = id ? 'PUT' : 'POST';
        let url = id ? `/graduados/${id}` : `/graduados`;

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

    // Eliminar
    $('#tablaGraduados tbody').on('click', '.btnEliminar', function() {
        if (confirm('¿Seguro que deseas eliminar este graduado?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/graduados/${id}`,
                method: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function(res) {
                    cargarTabla(); // recargar tabla
                }
            });
        }
    });

    function cargarTabla() {
        
        $('#tablaGraduados').DataTable({
            destroy: true,
            processing: true,
            responsive: true,
            ajax: '/graduados/data',
            columns: [
                { data: 'carnet_graduado' },
                { data: 'nombres' },
                { data: 'apellidos' },
                { data: 'genero' },
                {
                    data: null,
                    width: "10%",
                    orderable: false,
                    render: function(data, type, row) {
                        return `<div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button class="btn btn-sm btn-warning btnEditar" data-id="${row.id_graduado}">Editar</button>
                                    <button class="btn btn-sm btn-danger btnEliminar" data-id="${row.id_graduado}">Eliminar</button>
                                </div>
                        `;
                    }
                }
            ]
        });
    }
});
</script>
@endsection