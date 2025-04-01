@extends('layouts.app')

@section('title', 'Administrar Categorías')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Categorías</h2>
        <button class="btn btn-lima" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
            <i class="bi bi-plus-circle"></i> Nueva Categoría
        </button>
    </div>

    <div class="bg-white rounded shadow-sm border p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id_categoria }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-dark me-2 btn-editar-categoria"
                                        data-id="{{ $categoria->id_categoria }}"
                                        data-nombre="{{ $categoria->nombre }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editarCategoriaModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.categorias.destroy', $categoria->id_categoria) }}"
                                      class="d-inline-block form-eliminar">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">No hay categorías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $categorias->links() }}
        </div>
    </div>
</div>

{{-- Modal Crear --}}
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.categorias.store') }}" class="modal-content rounded-4 p-3">
            @csrf
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-lima w-100">Guardar</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Editar --}}
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editarCategoriaForm" class="modal-content rounded-4 p-3">
            @csrf @method('PUT')
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <label for="editar_nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="editar_nombre" class="form-control" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-lima w-100">Actualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Cargar datos en modal editar
        document.querySelectorAll('.btn-editar-categoria').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const nombre = btn.dataset.nombre;
                document.getElementById('editar_nombre').value = nombre;
                document.getElementById('editarCategoriaForm').action = `/admin/categorias/${id}`;
            });
        });

        // SweetAlert confirmación eliminar
        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¡Esta acción no se puede deshacer!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc3545'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // SweetAlert éxito
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush
