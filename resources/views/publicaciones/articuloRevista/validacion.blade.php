<script>
    $(document).ready(function () {
            
        $.validator.addMethod("regex", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("La entrada contiene elementos inválidos."));
    
        $.validator.addMethod("regexCuit", function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, $.validator.format("El CUIT/CUIL o pasaporte ingresado no es válido."));
        
        $.validator.addMethod("fechaFinMayor", function (fechaFin, element, param) {
            var fechaInicial = new Date($('#desde').val());
            var fechaFin = new Date($('#hasta').val());
            return this.optional(element) || fechaFin > fechaInicial;
        }, $.validator.format("La fecha final debe ser mayor que la inicial."));

        $.validator.addMethod("cNumero", $.validator.methods.number, "Solamente puede ingresar números enteros.");
        $.validator.addMethod("cMinimo", $.validator.methods.min, "Ingrese un número mayor o igual a 1.");
        $.validator.addMethod("cMaximo", $.validator.methods.max, "El número es demasiado grande.");
        $.validator.addMethod("cEntero", $.validator.methods.digits, "Solamente puede ingresar números enteros.");
        $.validator.addClassRules("numero", { cNumero: true, cMinimo: 1, cMaximo: 65536, cEntero: true });
    
        $("#formulario-articulo").validate({
            rules: {
                titulo: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 8,
                    maxlength: 255,
                    remote: {
                        url: '{{ route("checkTituloPublicacionRepetido") }}',
                        type: 'post',
                        data : {
                            idproyecto: function() {
                                return $("#id-publicacion").val();
                            }
                        }
                    }
                },
                titulo_revista: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 3,
                    maxlength: 45,
                },
                editorial: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 3,
                    maxlength: 45,
                },
                fecha_publicacion: {
                    required: true,
                },
                ciudad_edicion: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    minlength: 4,
                    maxlength: 45,
                },
                'apellido_autor[]': {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    required: true,
                    minlength: 4,
                    maxlength: 45,
                },
                'nombre_autor[]': {
                    regex: String.raw `^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s\.']+$`,
                    required: true,
                    minlength: 4,
                    maxlength: 45,
                },
                'cuit_autor[]': {
                    regexCuit: String.raw `^(20|23|24|27)\d{9}$|^[a-zA-Z]{3}\d{6}$`,
                    required: true,
                },
                issn: {
                    regex: String.raw `^[\d]{8}$`,
                },
                doi: {
                    regex: String.raw `^10.\d{4,9}/[-._;()/:A-Z0-9]+$`,
                }
            },
            messages: {
                titulo: {
                    required: "Ingrese el título del artículo.",
                    minlength: "Ingrese al menos 8 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                    remote: "Este título ya está en uso por otra publicación."
                },
                titulo_revista: {
                    required: "Ingrese el nombre de la revista.",
                    minlength: "Ingrese al menos 3 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                editorial: {
                    required: "Ingrese el nombre de la editorial.",
                    minlength: "Ingrese al menos 3 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                fecha_publicacion: {
                    required: "Ingrese la fecha de publicación."
                },
                'apellido_autor[]': {
                    required: "Ingrese el apellido del autor.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                'nombre_autor[]': {
                    required: "Ingrese el nombre del autor.",
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                'cuit_autor[]': {
                    required: "Ingrese el CUIT/CUIL/PAS del autor.",
                },
                ciudad_edicion: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                issn: {
                    regex: "El ISSN debe contener exactamente 8 dígitos.",
                },
                doi: {
                    regex: "El campo no contiene un DOI válido."
                }
            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar").attr("disabled", true);
            }
        });
    });
</script>