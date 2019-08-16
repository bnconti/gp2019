@extends("layout")

@section("titulo", "SIGAA - Modificación de artículo de revista")

@section("content")

@include("errores")

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Buscar";
    }
</style>

<form method="POST" action="/articuloRevista/{{ $articulo->id }}" id="formulario-articulo">
    @csrf
    @method('PATCH')

    <div class="card my-3">
        <h4 class="card-header">Formulario de modificación para artículo de revista</h4>
        <div class="card-body">

            <h5>Datos básicos</h5>
            <div class="row form-group">
                <div class="col-md-12">
                    <label class="col-form-label">Título (*)</label>
                    <input type="text" name="titulo" class="form-control" value="{{ $articulo->publicacion->titulo }}"
                        placeholder="Entre 8 y 255 caracteres alfanuméricos">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-5">
                    <label class="col-form-label">Nombre de revista (*)</label>
                    <input type="text" name="titulo_revista" class="form-control"
                        value="{{ $articulo->titulo_revista }}" placeholder="Entre 3 y 45 caracteres alfanuméricos">
                </div>

                <div class="col-md-5">
                    <label class="col-form-label">Editorial (*)</label>
                    <input type="text" class="form-control" name="editorial"
                        value="{{ $articulo->publicacion->editorial }}"
                        placeholder="Entre 3 y 45 caracteres alfanuméricos">
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Idioma</label>
                    <select name="idioma" class="form-control">
                        <option value="Español" {{ $articulo->publicacion->idioma == 'Español' ? 'selected' : '' }}>
                            Español</option>
                        <option value="Portugués" {{ $articulo->publicacion->idioma == 'Portugués' ? 'selected' : '' }}>
                            Portugués
                        </option>
                        <option value="Inglés" {{ $articulo->publicacion->idioma == 'Inglés' ? 'selected' : '' }}>Inglés
                        </option>
                        <option value="Otro" {{ $articulo->publicacion->idioma == 'Otro' ? 'selected' : '' }}>Otro
                        </option>
                    </select>
                </div>
            </div>

            <hr>

            <h5>Datos de publicación</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">País de edición </label>
                    <select name="pais_edicion" class="form-control">
                        <option value="Argentina"
                            {{ $articulo->publicacion->pais_edicion == 'Argentina' ? 'selected' : ''}}>
                            Argentina</option>
                        <option value="Brasil" {{ $articulo->publicacion->pais_edicion == 'Brasil' ? 'selected' : ''}}>
                            Brasil
                        </option>
                        <option value="España" {{ $articulo->publicacion->pais_edicion == 'España' ? 'selected' : ''}}>
                            España
                        </option>
                        <option value="EE. UU."
                            {{ $articulo->publicacion->pais_edicion == 'EE. UU.' ? 'selected' : ''}}>EE. UU.
                        </option>
                        <option value="Otro" {{ $articulo->publicacion->pais_edicion == 'Otro' ? 'selected' : '' }}>Otro
                        </option>

                    </select>
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Ciudad de edición</label>
                    <input type="text" class="form-control" name="ciudad_edicion"
                        value="{{ $articulo->publicacion->ciudad_edicion }}">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Fecha de publicación (*)</label>
                    <input type="date" class="form-control" name="fecha_publicacion"
                        value="{{ $articulo->publicacion->fecha_publicacion }}">
                </div>
            </div>

            <div class="row form-group">

                <div class="col-md-3">
                    <label class="col-form-label">Estado de publicación</label>
                    <select name="estado_publicacion" class="form-control">
                        <option value="Publicado"
                            {{ $articulo->publicacion->estado_publicacion == 'Publicado' ? 'selected' : ''}}>
                            Publicado</option>
                        <option value="En prensa"
                            {{ $articulo->publicacion->estado_publicacion == 'En prensa' ? 'selected' : ''}}>En
                            prensa</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Referato</label>
                    <select name="referato" class="form-control">
                        <option value="Nacional" {{ $articulo->referato == 'Nacional' ? 'selected' : ''}}>Nacional
                        </option>
                        <option value="Internacional" {{ $articulo->referato == 'Internacional' ? 'selected' : ''}}>
                            Internacional</option>
                        <option value="Ninguno" {{ $articulo->referato == 'Ninguno' ? 'selected' : ''}}>Ninguno</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Difusión</label>
                    <div class="form-control my-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="impreso" value="1"
                                {{ $articulo->publicacion->impreso == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="impreso">Impreso</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="digital" value="1"
                                {{ $articulo->publicacion->digital == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="digital">Digital</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">ISSN</label>
                    <input type="text" class="form-control" name="issn" value="{{ $articulo->issn }}"
                        placeholder="Ocho dígitos">
                </div>

            </div>

            <div class="row form-group">
                <div class="col">
                    <label class="col-form-label">Pág. inicial</label>
                    <input type="number" name="pag_inicial" min=1 class="form-control numero"
                        value="{{ $articulo->pag_inicial }}">
                </div>

                <div class="col">
                    <label class="col-form-label">Pág. final</label>
                    <input type="number" name="pag_final" min=1 class="form-control numero"
                        value="{{ $articulo->pag_final }}">
                </div>

                <div class="col">
                    <label class="col-form-label">Volumen</label>
                    <input type="number" name="volumen" min=1 class="form-control numero"
                        value="{{ $articulo->volumen }}">
                </div>

                <div class="col">
                    <label class="col-form-label">Tomo</label>
                    <input type="number" name="tomo" min=1 class="form-control numero" value="{{ $articulo->tomo }}">
                </div>

                <div class="col">
                    <label class="col-form-label">Nro.</label>
                    <input type="number" name="numero" min=1 class="form-control numero"
                        value="{{ $articulo->numero }}">
                </div>
            </div>

            <hr>

            <h5>Proyecto asociado</h5>
            <label class="col-form-label">Seleccionar (si lo hubiera) un proyecto asociado</label>
            <select name="id_proyecto" class="form-control">
                <option value="">N/A</option>
                @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}"
                    {{ $proyecto->id == $articulo->publicacion->proyectos_id ? 'selected' : ''}}>{{ $proyecto->titulo }}
                </option>
                @endforeach
            </select>

            <hr>

            <h5>Referencia</h5>
            <div class="row form-group">
                <div class="col-md-8">
                    <label class="col-form-label">Dirección URL</label>
                    <input type="text" class="form-control" name="url" value="{{ $articulo->publicacion->url }}">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">DOI</label>
                    <input type="text" class="form-control" name="doi" value="{{ $articulo->publicacion->doi }}"
                        placeholder="P. ej.: 10.1000/182">
                </div>
            </div>

            <hr>

            <h5>Resumen y palabras clave</h5>
            <div class="row form-group">
                <div class="col-md-9">
                    <label class="col-form-label">Resumen</label>
                    <textarea class="form-control" name="resumen"
                        rows="3">{{ $articulo->publicacion->resumen }}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Palabras clave</label>
                    <textarea class="form-control" name="palabras_claves"
                        rows="3">{{ $articulo->publicacion->keywords }}</textarea>
                </div>
            </div>

            <hr>

            <h5>Autor(es) (*)</h5>
            <div class="form-autor-principal">
                @foreach ($articulo->publicacion->autores as $autor)
                <div class="form-autor-campos">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="col-form-label">Apellido</label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                                id="apellido_autor" name="apellido_autor[]" value="{{ $autor->apellido }}"
                                placeholder="Entre 4 y 45 caracteres.">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Nombre</label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                                id="nombre_autor" name="nombre_autor[]" value="{{ $autor->nombre }}"
                                placeholder="Entre 4 y 45 caracteres.">
                        </div>

                        <div class="col-md-3">
                            <label class="col-form-label">CUIT/CUIL/PAS
                                <i class="fas fa-question-circle"
                                    title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                            </label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil"
                                id="cuit_autor" name="cuit_autor[]" value="{{ $autor->cuit_cuil }}"
                                placeholder="########### | AAA######">
                        </div>

                        @if ($loop->last)
                        <div class="col-md-1 mt-auto">
                            <span class="input-group-btn" id="agregar-autor">
                                <button class="btn btn-success btn-add boton-mas-autor" type="button">
                                    <span class="fas fa-plus"></span>
                                </button>
                            </span>
                        </div>
                        @else
                        <div class="col-md-1 mt-auto">
                            <span class="input-group-btn" id="quitar-autor">
                                <button class="btn btn-danger btn-add boton-quitar-autor" type="button">
                                    <span class="fas fa-minus"></span>
                                </button>
                            </span>
                        </div>
                        @endif
                    </div>

                    <hr>

                </div>
                @endforeach
            </div>

            <input hidden disabled type=text id="id-publicacion" value={{ $articulo->publicacion->id }}>

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

<script type="text/javascript">
    $(function()
        {
            // Script para agregar formularios extra
            $(document).on('click', '.boton-mas-autor', function(e)
            {
                e.preventDefault();
        
                var controlForm = $('.form-autor-principal'),
                    currentEntry = $(this).parents('.form-autor-campos:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.easyAutocomplete
                newEntry.find('input').val('');
        
                controlForm.find('.form-autor-campos:not(:last) .boton-mas-autor')
                    .removeClass('boton-mas-autor').addClass('boton-quitar-autor')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fas fa-minus"></span>');
                
            }).on('click', '.boton-quitar-autor', function(e)
            {
                $(this).parents('.form-autor-campos:first').remove();
        
                e.preventDefault();
                return false;
            });
        });
</script>

@include('publicaciones.articuloRevista.validacion')

@endpush