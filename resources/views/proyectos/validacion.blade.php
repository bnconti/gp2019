<script>
    $(document).ready(function () {
            
        $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("La entrada no respeta el formato indicado."));
    
        $.validator.addMethod("regexCuit", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("El CUIT/CUIL o pasaporte ingresado no es válido."));
        
        $.validator.addMethod("fechaFinMayor", function (fechaFin, element, param) {
            var fechaInicial = new Date($('#desde').val());
            var fechaFin = new Date($('#hasta').val());
            return this.optional(element) || fechaFin > fechaInicial;
        }, $.validator.format("La fecha final debe ser mayor que la inicial."));
    
    
        $("#formulario-proyecto").validate({
            rules: {
                titulo: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ,.\s\./:¿?¡!'-]+$`,
                    required: true,
                    minlength: 8,
                    maxlength: 255,
                    remote: {
                        url: '{{ route("checkTituloProyectoRepetido") }}',
                        type: 'post',
                        data : {
                            idproyecto: function() {
                                return $("#id-proyecto").val();
                            }
                        }
                    }
                },
                resolucion: {
                    regex: String.raw `^\d{4}\/\d{4}$`,
                    required: true,
                },
                expediente: {
                    regex: String.raw `^\d{3,4}\/\d{2,4}$`,
                    required: true,
                },
                desde: {
                    required: true,
                },
                hasta: {
                    fechaFinMayor: true,
                    required: true,
                },
                descripcion: {
                    required: true,
                    minlength: 20,
                    maxlength: 1000,
                },
                apellido_director: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    required: true,
                    minlength: 4,
                    maxlength: 45,
                },
                nombre_director: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    required: true,
                    minlength: 4,
                    maxlength: 45,
                },
                cuit_director: {
                    regexCuit: String.raw `^(20|23|24|27)\d{9}$|^[a-zA-Z]{3}\d{6}$`,
                    required: true,
                },
                apellido_codirector: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    minlength: 4,
                    maxlength: 45,
                },
                nombre_codirector: {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    minlength: 4,
                    maxlength: 45,
                },
                cuit_codirector: {
                    regexCuit: String.raw `^(20|23|24|27)\d{9}$|^[a-zA-Z]{3}\d{6}$`,
                },
            },
            messages: {
                titulo: {
                    required: "Ingrese el título del proyecto.",
                    minlength: "Ingrese al menos 8 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                    remote: "Este título ya está en uso por otro proyecto."
                },
                resolucion: {
                    required: "Ingrese el nro. de resolución.",
                },
                expediente: {
                    required: "Ingrese el expediente.",
                },
                desde: {
                    required: "Ingrese la fecha de inicio."
                },
                hasta: {
                    required: "Ingrese la fecha de finalización."
                },
                descripcion: {
                    required: "Ingrese una descripción del proyecto.",
                    minlength: "La descripción debe tener al menos 20 caracteres.",
                    maxlength: "Ha superado el máximo de 1000 caracteres",
                },
                apellido_director: {
                    required: "Ingrese el apellido del director del proyecto.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                nombre_director: {
                    required: "Ingrese el nombre del director del proyecto.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                cuit_director: {
                    required: "Ingrese el CUIT/CUIL/PAS del director del proyecto.",
                },
                apellido_codirector: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                nombre_codirector: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar").attr("disabled", true);
            }
        });
    });
</script>