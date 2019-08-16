@extends("layout")

@section("titulo", "SIGAA - Carga de parte de libro")

@section("content")

@include("errores")

<style>
    .custom-file-input~.custom-file-label::after {
        content: "Buscar";
    }
</style>

<form method="POST" action="/parteLibro" id="formulario-parte">
    @csrf

    <div class="card my-3">
        <h4 class="card-header">Formulario de carga para parte de libro</h4>
        <div class="card-body">

            <h5>Datos básicos</h5>

            <div class="row form-group">
                <div class="col-md-7">
                    <label class="col-form-label">Título de la parte (*)</label>
                    <input type="text" name="titulo_parte" class="form-control" value="{{ old('titulo_parte') }}"
                        placeholder="Entre 8 y 255 caracteres alfanuméricos">
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Tipo de parte</label>
                    <select name="tipo_parte" class="form-control">
                        <option value="Prólogo" {{ old('tipo_parte') == 'Prólogo' ? 'selected' : '' }}>Prólogo</option>
                        <option value="Capítulo" {{ old('tipo_parte') == 'Capítulo' ? 'selected' : '' }}>Capítulo
                        </option>
                        <option value="Otro" {{ old('tipo_parte') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Tomo</label>
                    <input type="number" min=1 name="tomo" class="form-control" value="{{ old('tomo') }}">
                </div>
            </div>


            <div class="row form-group">
                <div class="col-md-8">
                    <label class="col-form-label">Título del libro (*)</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}"
                        placeholder="Entre 8 y 255 caracteres alfanuméricos">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">ISBN</label>
                    <input type="number" name="ISBN" placeholder="ISBN 10 o 13, sin guiones" class="form-control"
                        value="{{ old('ISBN') }}">
                </div>

            </div>

            <div class="row form-group">

                <div class="col-md-3">
                    <label class="col-form-label">Idioma (*)</label>
                    <select name="idioma" class="form-control">
                        <option value="Español" {{ old('idioma') == 'Español' ? 'selected' : '' }}>Español</option>
                        <option value="Portugués" {{ old('idioma') == 'Portugués' ? 'selected' : '' }}>Portugués
                        </option>
                        <option value="Inglés" {{ old('idioma') == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                        <option value="Otro" {{ old('idioma') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Referato</label>
                    <select name="referato" class="form-control">
                        <option value="No" {{ old('referato') == 'No' ? 'selected' : ''}}>No</option>
                        <option value="Sí" {{ old('referato') == 'Sí' ? 'selected' : ''}}>Sí</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Cant. de págs. (*)</label>
                    <input type="number" min=1 class="form-control numero" name="cant_pags"
                        value="{{ old('cant_pags') }}">
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Pág. inicial</label>
                    <input type="number" min=1 class="form-control numero" name="pag_inicial"
                        value="{{ old('pag_inicial') }}">
                </div>

                <div class="col-md-2">
                    <label class="col-form-label">Pág. final</label>
                    <input type="number" min=1 class="form-control numero" name="pag_final"
                        value="{{ old('pag_final') }}">
                </div>
            </div>

            <hr>

            <h5>Datos de publicación</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">País de edición</label>
                    <select name="pais_edicion" class="form-control">
                        <option value="Argentina" {{ old('pais_edicion') == 'Argentina' ? 'selected' : ''}}>Argentina
                        </option>
                        <option value="Brasil" {{ old('pais_edicion') == 'Brasil' ? 'selected' : ''}}>Brasil</option>
                        <option value="España" {{ old('pais_edicion') == 'España' ? 'selected' : ''}}>España</option>
                        <option value="EE. UU." {{ old('pais_edicion') == 'EE. UU.' ? 'selected' : ''}}>EE. UU.</option>
                        <option value="Otro" {{ old('pais_edicion') == 'Otro' ? 'selected' : ''}}>Otro</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Ciudad de edición</label>
                    <input type="text" class="form-control" name="ciudad_edicion" value="{{ old('ciudad_edicion') }}" placeholder="Entre 4 y 45 caracteres.">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Fecha de publicación (*)</label>
                    <input type="date" class="form-control" name="fecha_publicacion"
                        value="{{ old('fecha_publicacion') }}">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-5">
                    <label class="col-form-label">Editorial (*)</label>
                    <input type="text" class="form-control" name="editorial" value="{{ old('editorial') }}"
                        placeholder="Entre 3 y 45 caracteres alfanuméricos">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Estado de publicación</label>
                    <select name="estado_publicacion" class="form-control">
                        <option value="En prensa" {{ old('estado_publicacion') == 'En prensa' ? 'selected' : ''}}>En
                            prensa</option>
                        <option value="Publicado" {{ old('estado_publicacion') == 'Publicado' ? 'selected' : ''}}>
                            Publicado</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Difusión</label>
                    <div class="form-control my-0">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="impreso" value="1"
                                {{ old('impreso') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="impreso">Impreso</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="digital" value="1"
                                {{ old('digital') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="digital">Digital</label>
                        </div>
                    </div>
                </div>

            </div>

            <hr>

            <h5>Proyecto asociado</h5>
            <label class="col-form-label">Seleccionar (si lo hubiera) un proyecto asociado</label>
            <select name="id_proyecto" class="form-control">
                <option value="">N/A</option>
                @foreach ($proyectos as $proyecto)
                <option value="{{ $proyecto->id }}" {{ old('id_proyecto') == $proyecto->id ? 'selected' : '' }}>
                    {{ $proyecto->titulo }}</option>
                @endforeach
            </select>

            <hr>

            <h5>Referencia</h5>
            <div class="row form-group">
                <div class="col-md-7">
                    <label class="col-form-label">Dirección URL</label>
                    <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                </div>

                <div class="col-md-5">
                    <label class="col-form-label">DOI</label>
                    <input type="text" class="form-control" name="doi" value="{{ old('doi') }}"
                        placeholder="P. ej.: 10.1000/182">
                </div>
            </div>

            <hr>

            <h5>Resumen y palabras clave</h5>
            <div class="row form-group">
                <div class="col-md-9">
                    <label class="col-form-label">Resumen</label>
                    <textarea class="form-control" name="resumen" rows="3">{{ old('resumen') }}</textarea>
                </div>

                <div class="col-md-3">
                    <label class="col-form-label">Palabras clave</label>
                    <textarea class="form-control" name="palabras_claves"
                        rows="3">{{ old('palabras_claves') }}</textarea>
                </div>
            </div>

            <hr>

            <h5>Autor(es) (*)</h5>
            <div class="form-autor-principal">
                <div class="form-autor-campos">
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label class="col-form-label">Apellido</label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                                id="apellido_autor" name="apellido_autor[]" value="{{ old('apellido_autor.0') }}"
                                placeholder="Entre 4 y 45 caracteres.">
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Nombre</label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                                id="nombre_autor" name="nombre_autor[]" value="{{ old('nombre_autor.0') }}"
                                placeholder="Entre 4 y 45 caracteres.">
                        </div>

                        <div class="col-md-3">
                            <label class="col-form-label">CUIT/CUIL/PAS
                                <i class="fas fa-question-circle"
                                    title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                            </label>
                            <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil"
                                id="cuit_autor" name="cuit_autor[]" value="{{ old('cuit_autor.0') }}"
                                placeholder="########### | AAA######">
                        </div>

                        {{--
                         <div class="col-md-2">
                            <label class="col-form-label">Rol</label>
                            <select name="rol" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Autor" {{ old('rol') == 'Autor' ? 'selected' : ''}}>Autor
                        </option>
                        <option value="Editor/Compilador" {{ old('rol') == 'Editor/Compilador' ? 'selected' : ''}}>
                            Editor/Compilador</option>
                        <option value="Revisor" {{ old('rol') == 'Revisor' ? 'selected' : ''}}>Revisor</option>
                        </select>
                    </div>
                    --}}

                    <div class="col-md-1 mt-auto">
                        <span class="input-group-btn" id="agregar-autor">
                            <button class="btn btn-success btn-add boton-mas-autor" type="button">
                                <span class="fas fa-plus"></span>
                            </button>
                        </span>
                    </div>
                </div>

                <hr>

            </div>
        </div>

        <div class="form-group row my-0">
            <div class="col-auto mr-auto">
                <a href="{{ route("publicaciones") }}" class="btn btn-secondary btn-lg" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-arrow-left fa-fw"></i>Volver
                </a>
            </div>

            <div class="col-auto">
                <button id="boton-guardar" type="submit" class="btn btn-success btn-lg" role="button" aria-haspopup="true"
                    aria-expanded="false"><i class="fas fa-save fa-fw"></i>Guardar</button>
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

@include('publicaciones.partedelibro.validacion')

@endpush