@extends("layout")

@section("titulo", "SIGAA - Cargar proyecto")

@section("content")

@include("errores")

<form method="POST" action="/proyectos" id="formulario-proyecto">
    @csrf
    <div class="card my-3">
        <h4 class="card-header">Formulario de carga para proyecto</h4>
        <div class="card-body">
            <h5>Datos del proyecto</h5>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="titulo" class="col-form-label">Título (*)</label>
                    <input name="titulo" id="titulo" type="text" value="{{ old('titulo') }}" class="form-control"
                        placeholder="Entre 8 y 255 caracteres alfanuméricos">
                </div>

                <div class="col-md-3">
                    <label for="resolucion" class="col-form-label">Resolución (*)</label>
                    <input name="resolucion" id="resolucion" type="text" value="{{ old('resolucion') }}"
                        class="form-control" placeholder="####/####">
                </div>

                <div class="col-md-3">
                    <label for="expediente" class="col-form-label">Expediente (*)</label>
                    <input name="expediente" id="expediente" type="text" value="{{ old('expediente') }}"
                        class="form-control" placeholder="####/####">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-3">
                    <label for="tipo_actividad" class="col-form-label">Tipo de actividad</label>
                    <select name="tipo_actividad" id="tipo_actividad" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Investigación básica"
                            {{ old('tipo_actividad') == 'Investigación básica' ? 'selected' : '' }}>Investigación básica
                        </option>
                        <option value="Investigación aplicada"
                            {{ old('tipo_actividad') == 'Investigación aplicada' ? 'selected' : '' }}>Investigación
                            aplicada</option>
                        <option value="Desarrollo experimental o tecnológico"
                            {{ old('tipo_actividad') == 'Desarrollo experimental o tecnológico' ? 'selected' : '' }}>
                            Desarrollo experimental o tecnológico</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tipo_proyecto" class="col-form-label">Tipo de proyecto</label>
                    <select name="tipo_proyecto" id="tipo_proyecto" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Extensión" {{ old('tipo_proyecto') == 'Extensión' ? 'selected' : '' }}>Extensión
                        </option>
                        <option value="Voluntariado" {{ old('tipo_proyecto') == 'Voluntariado' ? 'selected' : '' }}>
                            Voluntariado</option>
                        <option value="Investigación" {{ old('tipo_proyecto') == 'Investigación' ? 'selected' : '' }}>
                            Investigación</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="desde" class="col-form-label">Fecha de inicio (*)</label>
                    <input type='date' class="form-control" id="desde" name="desde" value="{{ old('desde') }}" />
                </div>

                <div class="col-md-3">
                    <label for="hasta" class="col-form-label">Fecha de finalización (*)</label>
                    <input type='date' class="form-control" id="hasta" name="hasta" value="{{ old('hasta') }}" />
                </div>

            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label for="descripcion" class="col-form-label">Breve descripción del proyecto o actividad bajo financiamiento (*)</label>
                    <textarea class="form-control" name="descripcion" placeholder="Máximo 1000 caracteres." rows=6>{{ old('descripcion') }}</textarea>
                </div>
            </div>

            <hr>

            <h5>Director del proyecto (*)</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_director" name="apellido_director" value="{{ old('apellido_director') }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre" id="nombre_director"
                        name="nombre_director" value="{{ old('nombre_director') }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>

                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil" id="cuit_director"
                        name="cuit_director" value="{{ old('cuit_director') }}" placeholder="########### | AAA######">

                </div>
            </div>

            <hr>

            <h5>Codirector del proyecto</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_codirector" name="apellido_codirector" placeholder="Entre 4 y 45 caracteres."
                        value="{{ old('apellido_codirector') }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                        id="nombre_codirector" name="nombre_codirector" placeholder="Entre 4 y 45 caracteres."
                        value="{{ old('nombre_codirector') }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS</label>
                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top"
                        title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    <input id="cuit_codirector" autocomplete="off" name="cuit_codirector" type="text"
                        class="form-control autocompletadoCuitCuil" placeholder="########### | AAA######"
                        value="{{ old('cuit_codirector') }}">
                </div>
            </div>

            <hr>

            <div class="form-group row my-0">
                <div class="col-auto mr-auto">
                    <a href="{{ route("proyectos.index") }}" class="btn btn-secondary btn-lg" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-arrow-left fa-fw"></i>Volver
                    </a>
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-success btn-lg" role="button" aria-haspopup="true"
                        aria-expanded="false" id="boton-guardar"><i class="fas fa-save fa-fw"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
@include('proyectos.autocompletado')
@include('proyectos.validacion')
@endpush