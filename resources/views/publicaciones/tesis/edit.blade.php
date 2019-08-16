@extends("layout")

@section("titulo", "SIGAA - Modificación de tesis o tesina")

@section("content")

@include("errores")

<form method="POST" action="/tesisTesina/{{ $tesis->id }}" id="formulario-tesis">
    @method('PATCH')
    @csrf

    <div class="card my-3">
        <h4 class="card-header">Formulario de modificación para tesis o tesina</h4>
        <div class="card-body">
            <h5>Datos básicos</h5>
            <div class="row form-group">
                <div class="col-md-7">
                    <label class="col-form-label">Título (*)</label>
                    <input type="text" name="titulo" class="form-control" value="{{ $tesis->publicacion->titulo }}"
                        placeholder="Entre 8 y 255 caracteres alfanuméricos">
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Nivel educativo correspondiente</label>
                    <select name="nivel_educativo" class="form-control">
                        <option value="Pregrado" {{ $tesis->nivel_educativo == 'Pregrado' ? 'selected' : '' }}>
                            Pregrado
                        </option>
                        <option value="Grado" {{ $tesis->nivel_educativo == 'Grado' ? 'selected' : '' }}>Grado</option>
                        <option value="Posgrado" {{ $tesis->nivel_educativo == 'Posgrado' ? 'selected' : '' }}>Posgrado
                        </option>
                        <option value="Doctorado" {{ $tesis->nivel_educativo == 'Doctorado' ? 'selected' : '' }}>
                            Doctorado
                        <option value="PPS" {{ $tesis->nivel_educativo == 'PPS' ? 'selected' : '' }}>
                            PPS
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Idioma</label>
                    <select name="idioma" class="form-control">
                        <option value="Español" {{ $tesis->publicacion->idioma == 'Español' ? 'selected' : '' }}>Español
                        </option>
                        <option value="Portugués" {{ $tesis->publicacion->idioma == 'Portugués' ? 'selected' : '' }}>
                            Portugués</option>
                        <option value="Inglés" {{ $tesis->publicacion->idioma == 'Inglés' ? 'selected' : '' }}>Inglés
                        </option>
                        <option value="Otro" {{ $tesis->publicacion->idioma == 'Otro' ? 'selected' : '' }}>Otro
                        </option>
                    </select>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Institución</label>
                    <select name="institucion" class="form-control">
                        <option value="UNNOBA">UNNOBA</option>
                        <option value="Otra">Otra</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Título obtenido (*)</label>
                    <input type="text" class="form-control" name="titulo_obtenido"
                        value="{{ $tesis->titulo_obtenido }}">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Fecha de defensa/aprobación (*)</label>
                    <input class="form-control" type="date" name="fecha_publicacion"
                        value="{{ $tesis->publicacion->fecha_publicacion }}">
                </div>
            </div>

            <hr>

            <h5>Referencia</h5>
            <div class="row form-group">
                <div class="col-md-7">
                    <label class="col-form-label">Dirección URL</label>
                    <input type="text" name="url" class="form-control" value="{{ $tesis->publicacion->url }}">
                </div>

                <div class="col-md-5">
                    <label class="col-form-label">DOI</label>
                    <input type="text" class="form-control" name="doi" value="{{ $tesis->publicacion->doi }}"
                        placeholder="P. ej.: 10.1000/182">
                </div>
            </div>

            <hr>

            <h5>Proyecto asociado</h5>
            <label class="col-form-label">Seleccionar (si lo hubiera) un Proyecto asociado</label>
            <select name="id_proyecto" class="form-control">
                <option value="">N/A</option>
                @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}"
                    {{ $tesis->publicacion->proyectos_id == $proyecto->id ? 'selected' : '' }}>{{ $proyecto->titulo }}
                </option>
                @endforeach
            </select>

            <hr>

            <h5>Resumen y palabras clave</h5>
            <div class="row form-group">
                <div class="col-md-9">
                    <label class="col-form-label">Resumen</label>
                    <textarea class="form-control" name="resumen" rows="3">{{ $tesis->publicacion->resumen }}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Palabras clave</label>
                    <textarea class="form-control" name="palabras_claves"
                        rows="3">{{ $tesis->publicacion->keywords }}</textarea>
                </div>
            </div>

            <hr>

            <h5>Director de tesis (*)</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        name="apellido_director" placeholder="Apellido"
                        value="{{ $tesis->publicacion->director->apellido }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                        name="nombre_director" placeholder="Nombre" value="{{ $tesis->publicacion->director->nombre }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil"
                        name="cuit_director" placeholder="CUIT/CUIL/PAS"
                        value="{{ $tesis->publicacion->director->cuit_cuil }}">
                </div>
            </div>

            <hr>

            <h5>Codirector de tesis</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_codirector" name="apellido_codirector" placeholder="Apellido"
                        value="{{ $tesis->publicacion->codirector ? $tesis->publicacion->codirector->apellido : ''}}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                        id="nombre_codirector" name="nombre_codirector" placeholder="Nombre"
                        value="{{ $tesis->publicacion->codirector ? $tesis->publicacion->codirector->nombre : '' }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil"
                        id="cuit_codirector" name="cuit_codirector" placeholder="CUIT/CUIL/PAS"
                        value="{{ $tesis->publicacion->codirector ? $tesis->publicacion->codirector->cuit_cuil : ''}}">
                </div>
            </div>

            <hr>

            <h5>Autor (*)</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_autor" name="apellido_autor" placeholder="Apellido"
                        value="{{ $tesis->publicacion->autores[0]->apellido }}" placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre" id="nombre_autor"
                        name="nombre_autor" placeholder="Nombre" value="{{ $tesis->publicacion->autores[0]->nombre }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil" id="cuit_autor"
                        name="cuit_autor" placeholder="CUIT/CUIL/PAS"
                        value="{{ $tesis->publicacion->autores[0]->cuit_cuil }}" placeholder="########### | AAA######">
                </div>
            </div>

            <hr>

            <input hidden disabled type=text id="id-publicacion" value={{ $tesis->publicacion->id }}>

            <div class="form-group row my-0">
                <div class="col-auto mr-auto">
                    <a href="{{ route("publicaciones") }}" class="btn btn-secondary btn-lg" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-arrow-left fa-fw"></i>Volver
                    </a>
                </div>

                <div class="col-auto">
                    <button id="boton-guardar" type="submit" class="btn btn-success btn-lg" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-save fa-fw"></i>Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')

<script>
    $(".autocompletadoCuitCuil").easyAutocomplete({
        url: function(search) {
            return "{{route('personaCuitCuil.search')}}?search=" + search;
        },
        getValue: "cuit_cuil"
    });

      $(".autocompletadoApellido").easyAutocomplete({
        url: function(search) {
            return "{{route('personaApellido.search')}}?search=" + search;
        },
        getValue: "apellido"
    });

      $(".autocompletadoNombre").easyAutocomplete({
        url: function(search) {
            return "{{route('personaNombre.search')}}?search=" + search;
        },
        getValue: "nombre"
    });
</script>

@include('publicaciones.tesis.validacion')

@endpush