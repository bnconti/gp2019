@extends("layout")

@section("titulo", "SIGAA - Usuarios")

@section("content")

@if ($message = Session::get('usuario_actualizado'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert"aria-label="cerrar">
                <span aria-hidden="true">&times;</span>
        </button> 	
        <strong><i class="fas fa-check-circle fa-fw"></i>{{ $message }}</strong>
</div>
@endif


<div class="card">
    <h4 class="card-header">Usuarios</h4>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-usuarios">
                <thead class="thead-light">
                    <tr>   
                        <th scope="col">Nombre completo</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Email institucional</th>
                        <th scope="col">Email personal</th>
                        <th scope="col">Habilitar</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
$(document).ready(function() {
    $('#tabla-usuarios').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('get.usuarios') !!}',
        columns: [
            { data: 'nombrecompleto', name: 'nombrecompleto', orderable: false, searchable: false },
            { data: 'rol', name: 'rol' },
            { data: 'mail_itt', name: 'mail_itt' },
            { data: 'gmail', name: 'gmail' },
            { data: 'switch', name: 'switch', orderable: false, searchable: false },
            { data: 'editar', name: 'editar', orderable: false, searchable: false },
        ],
        language: {
            search:        "Buscar:",
            info:          "Mostrando _START_ a _END_ de un total de _TOTAL_ elementos",
            lengthMenu:    "Mostrar _MENU_ elementos",
            paginate: {
                first:     "Primer",
                previous:  "Anterior",
                next:      "Siguiente",
                last:      "Último"
            },
            emptyTable:    "La tabla está vacía",
            processing:    "Cargando...",
        }
    });
});
</script>

@endpush