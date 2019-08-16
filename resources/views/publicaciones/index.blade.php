@extends("layout")

@section("titulo", "SIGAA - Publicaciones")

@section("content")

@include("notificaciones")
@include("errores")

<div class="card">
    <h5 class="card-header">Lista de tesis y tesinas</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-tesis">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título de la tesis/tesina</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Fecha de defensa/aprobación</th>
                        <th scope="col">Nivel educativo</th>
                        <th scope="col">Título obtenido</th>
                        <th scope="col">Institución</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <h5 class="card-header">Lista de trabajos para eventos</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-trabajos-eventos">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título del trabajo</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Fecha de publicación</th>
                        <th scope="col">Tipo de trabajo</th>
                        <th scope="col">Nombre de evento</th>
                        <th scope="col">Tipo de evento</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <h5 class="card-header">Lista de artículos de revista</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-articulo">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título del artículo</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Revista</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Fecha de publicación</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <h5 class="card-header">Lista de libros</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-libros">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título del libro</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Año de publicación</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <h5 class="card-header">Lista de partes de libros</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabla-parte-libros">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Título de la parte</th>
                        <th scope="col">Tipo de parte</th>
                        <th scope="col">Título del libro</th>
                        <th scope="col">Autor(es)</th>
                        <th scope="col">Editorial</th>
                        <th scope="col">Año de publicación</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

@include('publicaciones.tablas')

@endpush