@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <h5 class="mt-3" style="color: var(--bg-primary-custom)">Gestión de Usuarios</h5>
    </div>
    <div class="row mb-3">
        <div class="d-flex justify-content-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn bg-primary-custom btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                Agregar Usuario
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="">
            <table id="usuariosTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario">
                <div class="modal-header bg-primary-custom">
                    <h5 class="modal-title">Usuario</h5>
                    <button type="button" class="btn-close" data-bs-theme="dark" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="usuario_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control form-control-sm" id="passwordConfirm" name="">
                        <label for="" class="form-col-label-sm text-danger" id="msgPassword" style="display: none">Las contraseñas no coinciden</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary-custom btn-sm fw-bold">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
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
                        <button class="btn btn-warning btn-sm" onclick="editarUsuario(${data.id})"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(${data.id})"><i class="fa-solid fa-trash"></i></button>
                    `;
                }
            }
        ]
    });

    $('#formUsuario').submit(function(e) {
        e.preventDefault();
        if (!confirmPassword()) {
            customSwal.showAlert('Las contraseñas no coinciden','','','Ok','bg-primary-custom','warning');
            return;
        }
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

    $('#password, #passwordConfirm').on('input', function() {
        confirmPassword();
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

function confirmPassword() {
    let password = $('#password').val();
    let confirmPassword = $('#passwordConfirm').val();
    if (password !== confirmPassword) {
        $('#msgPassword').fadeIn();
        return false;
    } else {
        $('#msgPassword').fadeOut();
        return true;
    }
}
</script>
@endsection
