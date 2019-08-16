@extends("layout")

@section("titulo", "SIGAA - Proyectos")

@section("content")

@include("notificaciones")
@include("errores")

<div class="card">
    <h4 class="card-header">Lista de proyectos</h4>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-proyectos">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Resolución</th>
                        <th scope="col">Expediente</th>
                        <th scope="col">Director</th>
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
        $('#tabla-proyectos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.proyectos') !!}',            
            columns: [
                { data: 'titulo', name: 'titulo' },
                { data: 'resolucion', name: 'resolucion' },
                { data: 'expediente', name: 'expediente' },
                { data: 'nombre', name: 'nombre'},
                { data: 'editar', name: 'editar', orderable: false, searchable: false},
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
                emptyTable:    "No hay datos para mostrar",
                processing:    "Cargando...",
         }
         });
    });
</script>

@endpush
