@extends('layouts.app')

@section('title', 'Administrar Usuarios')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Usuarios</h2>
            <button class="btn btn-lima" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
                <i class="bi bi-plus-circle"></i> Nuevo Usuario
            </button>
        </div>

        {{-- Filtro --}}
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-3">
                <select name="tipo" class="form-select">
                    <option value="">Todos</option>
                    <option value="clientes" {{ request('tipo') == 'clientes' ? 'selected' : '' }}>Clientes</option>
                    <option value="empleados" {{ request('tipo') == 'empleados' ? 'selected' : '' }}>Empleados</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-funnel-fill"></i> Filtrar
                </button>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white rounded shadow-sm border p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-dark me-2 btn-editar-usuario"
                                        data-id="{{ $usuario->id }}"
                                        data-nombre="{{ $usuario->nombre }}"
                                        data-apellido="{{ $usuario->apellido }}"
                                        data-email="{{ $usuario->email }}"
                                        data-rol="{{ $usuario->rol }}"
                                        data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                        title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST"
                                        class="d-inline-block form-eliminar">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay usuarios encontrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{ $usuarios->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    {{-- Modal para crear usuario --}}
    <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.usuarios.store') }}" class="modal-content rounded-4 p-3">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="crearUsuarioLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="" disabled selected>Seleccione un rol</option>
                            <option value="admin">Administrador</option>
                            <option value="agente">Agente</option>
                            <option value="cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-lima w-100">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal para editar usuario --}}
    <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="" id="editarUsuarioForm" class="modal-content rounded-4 p-3">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="editarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editar_usuario_id">
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="editar_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_apellido" class="form-label">Apellido</label>
                        <input type="text" name="apellido" id="editar_apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_email" class="form-label">Correo</label>
                        <input type="email" name="email" id="editar_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_rol" class="form-label">Rol</label>
                        <select name="rol" id="editar_rol" class="form-select" required>
                            <option value="admin">Administrador</option>
                            <option value="agente">Agente</option>
                            <option value="cliente">Cliente</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editar_password" class="form-label">Contraseña (opcional)</label>
                        <input type="password" name="password" id="editar_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editar_password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" id="editar_password_confirmation"
                            class="form-control">
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-lima w-100">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesEditar = document.querySelectorAll('.btn-editar-usuario');
            botonesEditar.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nombre = this.dataset.nombre;
                    const apellido = this.dataset.apellido;
                    const email = this.dataset.email;
                    const rol = this.dataset.rol;

                    document.getElementById('editar_nombre').value = nombre;
                    document.getElementById('editar_apellido').value = apellido;
                    document.getElementById('editar_email').value = email;
                    document.getElementById('editar_rol').value = rol;
                    document.getElementById('editar_password').value = '';
                    document.getElementById('editar_password_confirmation').value = '';

                    const form = document.getElementById('editarUsuarioForm');
                    form.action = `/admin/usuarios/${id}`;
                });
            });

            // Confirmación con SweetAlert al eliminar usuario
            const deleteForms = document.querySelectorAll('form.form-eliminar');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '¡Esta acción no se puede deshacer!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    {{-- Éxito al crear o editar --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonColor: '#baf266',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#f44336'
        });
    </script>
@endif

@endpush
