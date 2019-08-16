@extends("layout")

@section("titulo", "SIGAA - Panel de Usuario" )

@section("content")

@include("notificaciones")
@include("errores")

<form method="POST" action="/usuarios/{{ $usuario->id }}" id="formulario-usuario">
    @method('PATCH')
    @csrf

    <div class="card">
        <h4 class="card-header">Datos del Usuario</h4>
        <div class="card-body">

            <h5>Datos personales</h5>
            <div class="row form-group">
                <div class="col-md-3">
                    <label class="col-form-label">Nombre completo (*)</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->persona->nombre }}">
                </div>
                <div class="col-md-2">
                    <label class="col-form-label">Apellido (*)</label>
                    <input type="text" name="apellido" class="form-control" value="{{ $usuario->persona->apellido }}">
                </div>
                <div class="col-md-4">
                    <label class="col-form-label">Email institucional (*)</label>
                    <input type="email" name="email_itt" class="form-control" value="{{ $usuario->mail_itt }}">
                </div>
                <div class="col-md-3">
                    <label class="col-form-label">CUIT/CUIL/PAS (*)</label>
                    <i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top"
                        title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i>
                    <input id="cuit_codirector" autocomplete="off" name="cuit" type="text" class="form-control"
                        placeholder="########### | AAA######" value="{{ $usuario->persona->cuit_cuil }}">
                </div>
            </div>

            <hr>

            <h5>Funciones</h5>
            <div class="row form-group">
                <div class="col-md-4">
                    <label for="rol" class="col-form-label">Rol</label>
                    <select class="form-control" name="rol">
                        <option selected value="{{ $usuario->rol }}">{{ $usuario->rol }}</option>
                        <option value="Docente Investigador">Docente Investigador</option>
                        <option value="Becario de Posgrado">Becario de Posgrado</option>
                        <option value="Becario de Grado">Becario de Grado</option>
                        <option value="Personal de apoyo">Personal de apoyo</option>
                        <option value="Estudiante">Estudiante</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="cargo" class="col-form-label">Cargo</label>
                    <select class="form-control" name="cargo">
                        <option selected value="{{ $usuario->cargo }}">{{ $usuario->cargo }}</option>
                        <option value="Profesor titular">Profesor titular</option>
                        <option value="Profesor asociado">Profesor asociado</option>
                        <option value="Profesor adjunto">Profesor adjunto</option>
                        <option value="Jefe de trabajos prácticos">Jefe de trabajos prácticos</option>
                        <option value="Ayudante diplomado">Ayudante diplomado</option>
                        <option value="Ayudante de segunda">Ayudante de segunda
                        </option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="dedicacion" class="col-form-label">Dedicación</label>
                    <select class="form-control" name="dedicacion">
                        <option selected value="{{ $usuario->dedicacion }}">{{ $usuario->dedicacion }}</option>
                        <option value="Simple">Simple</option>
                        <option value="Semiexclusiva">Semiexclusiva</option>
                        <option value="Completa">Completa</option>
                        <option value="Exclusiva">Exclusiva
                        </option>
                    </select>
                </div>
            </div>

            <hr>

            <div class="form-group row my-0">
                <div class="col-auto mr-auto">
                    <a href="{{ route('proyectos.index') }}" class="btn btn-secondary btn-lg" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-arrow-left fa-fw"></i>Volver
                    </a>
                </div>

                <div class="col-auto ml-auto">
                    <button id="boton-guardar" type="submit" class="btn btn-success btn-lg" role="button" aria-haspopup="true"
                        aria-expanded="false"><i class="fas fa-save fa-fw"></i>Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="card">
    <h4 class="card-header">Cambiar contraseña</h4>
    <div class="card-body">
        <form method="POST" action="/cambiarContra/{{ $usuario->id }}" id="cambiar-pass">
            @method('PATCH')
            @csrf

            <div class="d-flex">

                <div class="flex-fill p-2 form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="pass_vieja" id="pass_vieja" class="form-control"
                            placeholder="Ingresar contraseña actual" type="password">
                    </div>
                    <small><i>Dejar vacío si nunca especificó una contraseña.</i></small>
                </div>

                <div class="flex-fill p-2 form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="pass_nueva" id="pass_nueva" class="form-control pass"
                            placeholder="Contraseña nueva" type="password">
                    </div>
                </div>

                <div class="flex-fill p-2 form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        </div>
                        <input name="pass_r" class="form-control pass" placeholder="Repetir contraseña nueva"
                            type="password">
                    </div>
                </div>

                <div class="justify-content-end">
                    <div class="flex-fill p-2">
                        <button id="boton-guardar-pass" type="submit" class="btn btn-success"><i
                                class="fas fa-save fa-fw"></i>Guardar</button>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>

<div class="card">
    <h4 class="card-header">Participación en Proyectos</h4>
    <div class="card-body">
        <form method="POST" action="/usuarios/agregarProyecto/{{ $usuario->persona->id }}">
            @method('PATCH')
            @csrf
            <div class="d-flex align-items-center">
                <div class="input-group mb-3" style="padding-right: 10px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sumarse como miembro</span>
                    </div>

                    <select name="proyectoId" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach ($proyectosTodos as $proyecto)
                        <option value="{{ $proyecto->id }}">{{ $proyecto->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="padding: 5px"><button type="submit" class="btn btn-secondary">Agregar</button></div>
            </div>
        </form>

        <table class="table table-bordered table-hover" id="tabla-usuarios-proyectos">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Lista de Proyectos de los cuales es miembro</th>
                    <th scope="col">Darse de baja</th>
                </tr>
            </thead>
            @foreach ($proyectosDelUsuario as $proyecto)
            <tbody>
                <td>{{ $proyecto->titulo }}</td>
                <td><a href="/usuarios/removerProyecto/{{ $usuario->persona->id }}/{{$proyecto->id}}"
                        class="btn btn-xs btn-info"><i class="fas fa-trash"></i></a> </td>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

<div class="card">
    <h4 class="card-header">Autoría de Publicaciones</h4>
    <div class="card-body">
        <form method="POST" action="/usuarios/agregarPublicacion/{{ $usuario->persona->id }}">
            @method('PATCH')
            @csrf
            <div class="d-flex align-items-center">
                <div class="input-group mb-3" style="padding-right: 10px">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Añadirse como autor</span>
                    </div>

                    <select name="publicacionId" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach ($publicaciones as $publicacion)
                        <option value="{{ $publicacion->id }}">{{ $publicacion->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="padding: 5px"><button type="submit" class="btn btn-secondary">Agregar</button></div>
            </div>
        </form>

        <table class="table table-bordered table-hover" id="tabla-usuarios-proyectos">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Lista de Publicaciones</th>
                    <th scope="col">Dar de baja</th>
                </tr>
            </thead>
            @foreach ($publicacionesDelUsuario as $publicacion)
            <tbody>
                <td>{{ $publicacion->titulo }}</td>
                <td><a href="/usuarios/removerPublicacion/{{ $usuario->persona->id }}/{{$publicacion->id}}"
                        class="btn btn-xs btn-info"><i class="fas fa-trash"></i></a> </td>
            </tbody>
            @endforeach
        </table>
    </div>
</div>

{{-- 
<div class="card">
    <h4 class="card-header">Datos académicos</h4>
    <div class="card-body">
        <h5>Títulos de grado</h5>
        <div class="form-titulos">
            <div class="form-titulos-campos">
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre_titulos[]">Nombre</label>
                            <input type="text" class="form-control" name="nombre_titulos[]" disabled>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="institucion_titulos[]">Institucion</label>
                            <input type="text" class="form-control" name="institucion_titulos[]" disabled>
                        </div>
                    </div>

                    <div class="col-md-1 mt-auto">
                        <span class="input-group-btn" id="agregar-titulo">
                            <button class="btn btn-success boton-mas-titulo" type="button">
                                <span class="fas fa-plus"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <h5>Títulos de postgrado</h5>
        <div class="form-postgrados">
            <div class="form-postgrados-campos">
                <div class="form-group row">

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_postgrados[]">Nombre</label>
                            <input type="text" class="form-control" name="nombre_postgrados[]" disabled>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="institucion_postgrados[]">Institucion</label>
                            <input type="text" class="form-control" name="institucion_postgrados[]" disabled>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="finalizado_postgrados[]">Finalizado</label>
                            <input type="checkbox" class="form-control" name="finalizado_postgrados[]" disabled>
                        </div>
                    </div>

                    <div class="col-md-1 mt-auto">
                        <span class="input-group-btn" id="agregar-postgrado">
                            <button class="btn btn-success boton-mas-postgrado" type="button">
                                <span class="fas fa-plus"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
--}}

@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $.validator.addMethod("requerido", $.validator.methods.required, "Ingrese la nueva contraseña.");
        $.validator.addMethod("min", $.validator.methods.minlength, "Al menos 8 caracteres.");
        $.validator.addMethod("max", $.validator.methods.maxlength, "Superó el máximo de 45 caracteres.");

        $.validator.addClassRules("pass", {requerido: true, min: 8, max: 45});

        $("#cambiar-pass").validate({
            rules: {
                pass_r: {
                    equalTo: "#pass_nueva",
                },
            },
            messages: {
                pass_r: {
                    equalTo: "Las contraseñas deben coincidir."
                }
            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar-pass").attr("disabled", true);
            },
            errorPlacement: function (error, element) {
                if(element.parent().hasClass('input-group')){
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
        });
    });

    
</script>

<script>
    $(document).ready(function () {
        $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("La entrada contiene elementos inválidos."));

        $("#formulario-usuario").validate({
            rules: {
                apellido: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    minlength: 4,
                    maxlength: 45,
                },
                nombre: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    minlength: 4,
                    maxlength: 45,
                },
                email_itt: {
                    required: true,
                    email: true,
                },
                cuit: {
                    required: true,
                    regex: String.raw `^(20|23|24|27)\d{9}$|^[a-zA-Z]{3}\d{6}$`,
                },
            },
            messages: {
                email_itt: {
                    required: "Por favor, complete el campo con su dirección de correo institucional.",
                    email: "Lo que ingresó no parece ser una dirección de correo válida.",
                },
                apellido: {
                    required: "Ingrese su apellido.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                nombre: {
                    required: "Ingrese su nombre completo.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                cuit: {
                    required: "Ingrese su CUIT/CUIT/PAS.",
                    regex: "El formato del CUIT/CUIL/PAS ingresado es incorrecto.",
                },
                pass_r: {
                    equalTo: "Las contraseñas deben coincidir.",
                },

            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar").attr("disabled", true);
            }
        });
    });
</script>

<script>
    function eliminarRepetidos(campo) {
        $('select[name="'+campo+'"] > option').each(function () {
            var code = {};
            if(code[this.text]) {
                $(this).remove();
            } else {
                code[this.text] = this.value;
            }
        });
    }

    eliminarRepetidos('rol');
    eliminarRepetidos('dedicacion');
    eliminarRepetidos('cargo');
</script>

{{-- 
<script type="text/javascript">
    $(function() {
    $(document).on('click', '.boton-mas-titulo', function(e) {
        e.preventDefault();

        var controlForm = $('.form-titulos'),
            currentEntry = $(this).parents('.form-titulos-campos:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');

        controlForm.find('.form-titulos-campos:not(:last) .boton-mas-titulo')
            .removeClass('boton-mas-titulo').addClass('boton-quitar-titulo')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fas fa-minus"></span>');
    }).on('click', '.boton-quitar-titulo', function(e) {
        $(this).parents('.form-titulos-campos:first').remove();

        e.preventDefault();
        return false;
    });
});
</script>

<script type="text/javascript">
    $(function() {
    $(document).on('click', '.boton-mas-postgrado', function(e) {
        e.preventDefault();

        var controlForm = $('.form-postgrados'),
            currentEntry = $(this).parents('.form-postgrados-campos:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');

        controlForm.find('.form-postgrados-campos:not(:last) .boton-mas-postgrado')
            .removeClass('boton-mas-postgrado').addClass('boton-quitar-postgrado')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fas fa-minus"></span>');
    }).on('click', '.boton-quitar-postgrado', function(e) {
        $(this).parents('.form-postgrados-campos:first').remove();

        e.preventDefault();
        return false;
    });
});
</script>
 --}}

@endpush