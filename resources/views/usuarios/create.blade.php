<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIGAA - Registro de cuenta local</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <style>
        label.error {
            color: red;
            font-size: 0.75em;
            display: inline;
            font-weight: 600;
        }

        input.error,
        select.error {
            border: 1px dashed red;
            font-weight: 300;
            color: red;
        }
    </style>

</head>

<body>

    @include("notificaciones")
    @include("errores")

    <div class="container">

        <br>

        <form method="POST" action="/usuarios" id="formulario-usuario">
            @csrf

            <div class="card bg-light">
                <article class="card-body mx-auto" style="max-width: 400px;">
                    <h4 class="card-title mt-3 text-center">Crear cuenta local</h4>
                    <p class="text-center">Complete el siguiente formulario con sus datos</p>
                    <div class="card-body">

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="nombre" class="form-control texto" placeholder="Nombre" type="text">
                            </div> <!-- form-group// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="apellido" class="form-control texto" placeholder="Apellido" type="text">
                            </div> <!-- form-group// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input id="email_itt" name="email_itt" class="form-control"
                                    placeholder="Email institucional" type="email">
                            </div>
                        </div> <!-- form-group// -->

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input name="email_alt" class="form-control"
                                    placeholder="Email alternativo (Outlook, Gmail, etc.)" type="email">
                            </div> <!-- form-group// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="far fa-address-card"></i></i>
                                    </span>
                                </div>

                                <input name="cuit" class="form-control" placeholder="CUIT/CUIL/PAS" type="text">

                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-question-circle"
                                            data-toggle="tooltip" data-placement="top"
                                            title="11 dígitos para el CUIT/CUIL o 3 caracteres y 5 dígitos para el pasaporte"></i></span>
                                </div>
                            </div> <!-- form-group// -->
                        </div>

                        <div class="form-group">
                            <div class=" input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select class="form-control" name="rol">
                                    <option value="default" selected>Seleccione su rol</option>
                                    <option value="Docente Investigador">Docente Investigador</option>
                                    <option value="Becario de Posgrado">Becario de Posgrado</option>
                                    <option value="Becario de Grado">Becario de Grado</option>
                                    <option value="Personal de apoyo">Personal de apoyo</option>
                                    <option value="Estudiante">Estudiante</option>
                                    <option value="Usuario">Usuario</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div> <!-- form-group end.// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select class="form-control" name="dedicacion">
                                    <option value="default" selected>Seleccione su tipo de dedicación</option>
                                    <option value="Simple">Simple</option>
                                    <option value="Semiexclusiva">Semiexclusiva</option>
                                    <option value="Completa">Completa</option>
                                    <option value="Exclusiva">Exclusiva</option>
                                </select>
                            </div> <!-- form-group end.// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                                </div>
                                <select class="form-control" name="cargo">
                                    <option value="default" selected>Seleccione su cargo</option>
                                    <option value="Profesor titular">Profesor titular</option>
                                    <option value="Profesor asociado">Profesor asociado</option>
                                    <option value="Profesor adjunto">Profesor adjunto</option>
                                    <option value="Jefe de trabajos prácticos">Jefe de trabajos prácticos</option>
                                    <option value="Ayudante diplomado">Ayudante diplomado</option>
                                    <option value="Ayudante de segunda">Ayudante de segunda
                                    </option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div> <!-- form-group end.// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="pass" id="pass" class="form-control" placeholder="Ingresar contraseña"
                                    type="password">
                            </div> <!-- form-group// -->
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input name="pass_r" class="form-control" placeholder="Repetir contraseña"
                                    type="password">
                            </div> <!-- form-group// -->
                        </div>

                        <div id="cajita"></div>

                        <div class="form-group">
                            <button type="submit" id="boton-guardar" class="btn btn-primary btn-block">Crear
                                cuenta</button>
                        </div> <!-- form-group// -->

                        <p class="text-center"><a href="/">Volver al inicio</a> </p>

                </article>
            </div> <!-- card.// -->
        </form>
    </div>
</body>

</html>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script src=" {{ asset('js/jquery.validate.js') }}"></script>

<script>
    $(document).ready(function () {
        $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("La entrada contiene elementos inválidos."));

        $.validator.addMethod("valueNotEquals", function(value, element, arg){
            return arg !== value;
        }, "Por favor, seleccione un campo.");

        $.validator.addMethod("requerido", $.validator.methods.required, "Complete este campo.");
        $.validator.addMethod("regex", $.validator.methods.regex, "La entrada contiene elementos inválidos.");
        $.validator.addMethod("min", $.validator.methods.minlength, "Ingrese al menos 4 caracteres.");
        $.validator.addMethod("max", $.validator.methods.maxlength, "Superó el nro. máx. de caracteres (45).");
        $.validator.addClassRules("texto", {requerido: true, regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`, min: 4, max: 45 });

        $("#formulario-usuario").validate({
            rules: {
                email_itt: {
                    required: true,
                    email: true,
                    remote: {
                        url: '{{ route("checkEmailUsado") }}',
                        type: 'post',
                        data : {
                            email_itt: function() {
                                return $("#email_itt").val();
                            }
                        }
                    }
                },
                email_alt: {
                    required: true,
                    email: true,
                },
                cuit: {
                    required: true,
                    regex: String.raw `^(20|23|24|27)\d{9}$|^[a-zA-Z]{3}\d{6}$`,
                },
                rol: {
                    valueNotEquals: "default",
                },
                dedicacion: {
                    valueNotEquals: "default",
                },
                cargo: {
                    valueNotEquals: "default",
                },
                pass: {
                    required: true,
                    minlength: 8,
                },
                pass_r: {
                    required: true,
                    equalTo: "#pass",
                }
            },
            messages: {
                email_itt: {
                    required: "Ingrese su dirección de correo institucional.",
                    email: "Lo que ingresó no parece ser una dirección de correo válida.",
                    remote: "Este correo ya está en uso.",
                },
                email_alt: {
                    required: "Ingrese su dirección de correo personal.",
                    email: "Lo que ingresó no parece ser una dirección de correo válida.",
                },
                cuit: {
                    required: "Ingrese su CUIT/CUIT/PAS.",
                    regex: "El formato del CUIT/CUIL/PAS ingresado es incorrecto.",
                },
                rol: {
                    valueNotEquals: "Seleccione una opción.",
                },
                dedicacion: {
                    valueNotEquals: "Seleccione una opción.",
                },
                cargo: {
                    valueNotEquals: "Seleccione una opción.",
                },
                pass: {
                    required: "Ingrese su contraseña.",
                    minlength: "La contraseña debe tener al menos 8 caracteres.",
                },
                pass_r: {
                    required: "Ingrese su contraseña.",
                    equalTo: "Las contraseñas deben coincidir.",
                },
            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar").attr("disabled", true);
            },
            errorPlacement: function (error, element) {
                if(element.parent().hasClass('input-group')){
                    error.insertAfter(element.parent());
                }else{
                    error.insertAfter(element);
                }
            },
        });
    });
</script>