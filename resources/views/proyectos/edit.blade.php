@extends("layout")

@section("titulo", "SIGAA - Editar proyecto")

@section("content")

@include("errores")

<form method="POST" action="/proyectos/{{ $proyecto->id }}" id="formulario-proyecto">
    @method('PATCH')
    @csrf
    
    <div class="card my-3">
        <h4 class="card-header">Formulario de modificación de proyecto</h4>
        <div class="card-body">
            <h5>Datos del proyecto</h5>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="titulo" class="col-form-label">Título (*)</label>
                    <input name="titulo" id="titulo" type="text" value="{{ $proyecto->titulo }}" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="resolucion" class="col-form-label">Resolución (*)</label>
                    <input name="resolucion" id="resolucion" type="text" value="{{ $proyecto->resolucion }}"
                        class="form-control" placeholder="####/####">
                </div>

                <div class="col-md-3">
                    <label for="expediente" class="col-form-label">Expediente (*)</label>
                    <input name="expediente" id="expediente" type="text" class="form-control"
                        value="{{ $proyecto->expediente }}" placeholder="####/####">
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-3">
                    <label for="tipo_actividad" class="col-form-label">Tipo de actividad</label>
                    <select name="tipo_actividad" id="tipo_actividad" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Investigación básica"
                            {{ $proyecto->tipo_actividad == 'Investigación básica' ? 'selected' : '' }}>
                            Investigación básica</option>
                        <option value="Investigación aplicada"
                            {{ $proyecto->tipo_actividad == 'Investigación aplicada' ? 'selected' : '' }}>
                            Investigación aplicada</option>
                        <option value="Desarrollo experimental o tecnológico"
                            {{ $proyecto->tipo_actividad == 'Desarrollo experimental o tecnológico' ? 'selected' : '' }}>
                            Desarrollo experimental o tecnológico</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tipo_proyecto" class="col-form-label">Tipo de proyecto</label>
                    <select name="tipo_proyecto" id="tipo_proyecto" class="form-control">
                        <option value="">Seleccione</option>
                        <option value="Extensión" {{ $proyecto->tipo_proyecto == 'Extensión' ? 'selected' : '' }}>
                            Extensión</option>
                        <option value="Voluntariado" {{ $proyecto->tipo_proyecto == 'Voluntariado' ? 'selected' : '' }}>
                            Voluntariado
                        </option>
                        <option value="Investigación"
                            {{ $proyecto->tipo_proyecto == 'Investigación' ? 'selected' : '' }}>Investigación
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="desde" class="col-form-label">Fecha de inicio (*)</label>
                    <input type='date' class="form-control" id="desde" name="desde" value="{{ $proyecto->desde }}" />
                </div>

                <div class="col-md-3">
                    <label for="hasta" class="col-form-label">Fecha de finalización (*)</label>
                    <input type='date' class="form-control" id="hasta" name="hasta" value="{{ $proyecto->hasta }}" />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-12">
                    <label for="descripcion" class="col-form-label">Breve descripción del proyecto o actividad bajo financiamiento (*)</label>
                    <textarea maxlength=2000 class="form-control" name="descripcion" placeholder="Máximo 1000 caracteres." rows=6>{{ $proyecto->descripcion }}</textarea>
                </div>
            </div>

            <hr>

            <h5>Director del proyecto (*)</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_director" name="apellido_director" value="{{ $proyecto->director->apellido }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre" id="nombre_director"
                        name="nombre_director" value="{{ $proyecto->director->nombre }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil" id="cuit_director"
                        name="cuit_director" value="{{ $proyecto->director->cuit_cuil }}"
                        placeholder="########### | AAA######">
                </div>
            </div>

            <hr>

            <h5>Codirector del proyecto</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label class="col-form-label">Apellido</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoApellido"
                        id="apellido_codirector" name="apellido_codirector"
                        value="{{ $proyecto->codirector ? $proyecto->codirector->apellido : '' }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Nombre</label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoNombre"
                        id="nombre_codirector" name="nombre_codirector"
                        value="{{ $proyecto->codirector ? $proyecto->codirector->nombre : '' }}"
                        placeholder="Entre 4 y 45 caracteres.">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">CUIT/CUIL/PAS
                        <i class="fas fa-question-circle"
                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    </label>
                    <input type="text" autocomplete="off" class="form-control autocompletadoCuitCuil"
                        id="cuit_codirector" name="cuit_codirector"
                        value="{{ $proyecto->codirector ? $proyecto->codirector->cuit_cuil : '' }}"
                        placeholder="########### | AAA######">
                </div>
            </div>

            {{-- Agrego este campo invisible para poder pasarle el ID al script de validación del título --}}
            <input hidden disabled type=text id="id-proyecto" value={{ $proyecto->id }}>

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
                        aria-expanded="false" id="boton-guardar"><i class="fas fa-save fa-fw"></i>Actualizar</button>
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