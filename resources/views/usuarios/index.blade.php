@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gestión de Usuarios</h2>
    <button class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#modalUsuario">Agregar</button>

    <table id="usuariosTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario">
                <div class="modal-header">
                    <h5 class="modal-title">Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="usuario_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let table;

$(document).ready(function() {
    table = $('#usuariosTable').DataTable({
        ajax: '/usuarios/lista',
        columns: [
            { data: 'name' },
            { data: 'email' },
            { 
                data: null,
                render: function(data) {
                    return `
                        <button class="btn btn-warning btn-sm" onclick="editarUsuario(${data.id})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${data.id})">Eliminar</button>
                    `;
                }
            }
        ]
    });

    $('#formUsuario').submit(function(e) {
        e.preventDefault();
        let id = $('#usuario_id').val();
        let url = id ? `/usuarios/${id}` : '/usuarios';
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}',
                _method: method
            },
            success: function() {
                $('#modalUsuario').modal('hide');
                table.ajax.reload();
                $('#formUsuario')[0].reset();
                $('#usuario_id').val('');
            },
            error: function(xhr) {
                alert('Error al guardar usuario');
                console.log(xhr.responseJSON.errors);
            }
        });
    });
});

function editarUsuario(id) {
    $.get(`/usuarios/lista`, function(data) {
        let user = data.data.find(u => u.id == id);
        $('#usuario_id').val(user.id);
        $('#name').val(user.name);
        $('#email').val(user.email);
        $('#password').val('');
        $('#modalUsuario').modal('show');
    });
}

function eliminarUsuario(id) {
    if (confirm('¿Deseas eliminar este usuario?')) {
        $.ajax({
            url: `/usuarios/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                table.ajax.reload();
            }
        });
    }
}
</script>
@endsection
