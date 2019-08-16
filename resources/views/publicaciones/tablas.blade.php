<script>
    $(document).ready(function() {
        $('#tabla-tesis').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.tesis') !!}',
            columns: [
                { data: 'titulo', name: 'titulo' },
                { data: 'autor', name: 'autor' },
                { data: 'fecha_publicacion', name: 'fecha_publicacion' },
                { data: 'nivel_educativo', name: 'nivel_educativo' },
                { data: 'titulo_obtenido', name: 'titulo_obtenido' },
                { data: 'institucion', name: 'institucion' },
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

<script>
    $(document).ready(function() {
        $('#tabla-trabajos-eventos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.trabajos') !!}',
            columns: [
                { data: 'titulo', name: 'titulo' },
                { data: 'autores', name: 'autores' },
                { data: 'anio', name: 'anio' },
                { data: 'tipo_trabajo', name: 'tipo_trabajo'},
                { data: 'nombre_evento', name: 'nombre_evento'},
                { data: 'tipo_evento', name: 'tipo_evento'},
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

<script>
    $(document).ready(function() {
        $('#tabla-articulo').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.articulos') !!}',
            columns: [
                { data: 'titulo', name: 'titulo' },
                { data: 'autores', name: 'autores' },
                { data: 'titulo_revista', name: 'titulo_revista' },
                { data: 'editorial', name: 'editorial' },
                { data: 'fecha', name: 'fecha' },
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
                emptyTable:    "La tabla está vacía",
                processing:    "Cargando...",
         }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#tabla-libros').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.libros') !!}',
            columns: [
                { data: 'titulo' },
                { data: 'autores' },
                { data: 'editorial' },
                { data: 'anio' },
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

<script>
    $(document).ready(function() {
        $('#tabla-parte-libros').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('get.parteslibro') !!}',
            columns: [
                { data: 'titulo_parte' },
                { data: 'tipo_parte' },
                { data: 'titulo' },
                { data: 'autores' },
                { data: 'editorial' },
                { data: 'anio' },
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