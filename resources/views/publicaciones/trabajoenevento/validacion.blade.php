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
    
        $("#formulario-trabajo").validate({
            rules: {
                titulo: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 8,
                    maxlength: 255,
                },
                titulo_librorevista: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 3,
                    maxlength: 45,
                },
                editorial: {
                    regex: String.raw `^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s\.:¿?¡!'-/&]+$`,
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                },
                fecha_publicacion: {
                    required: true,
                },
                fecha_evento: {
                    required: true,
                },
                ciudad_edicion: {
                    minlength: 4,
                    maxlength: 45,
                },
                nombre_evento: {
                    minlength: 4,
                    maxlength: 45,
                },
                ciudad_evento: {
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
                doi: {
                    regex: String.raw `^10.\d{4,9}/[-._;()/:A-Z0-9]+$`,
                },
                ISSN_ISBN: {
                    regex: String.raw `^(97(8|9))?\d{9}(\d|X)$|^[\d]{8}$`
                },
            },
            messages: {
                titulo: {
                    required: "Ingrese el título del libro.",
                    minlength: "Ingrese al menos 8 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                    remote: "Este título ya está en uso por otra publicación."
                },
                titulo_librorevista: {
                    required: "Ingrese el título de la revista o libro.",
                    minlength: "Ingrese al menos 3 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                editorial: {
                    required: "Ingrese el nombre de la editorial.",
                    minlength: "Ingrese al menos 3 caracteres.",
                    maxlength: "Ha superado el máximo de 255 caracteres.",
                },
                ciudad_edicion: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                ciudad_evento: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                nombre_evento: {
                    minlength: "Ingrese al menos 4 caracteres.",
                    maxlength: "Ha superado el máximo de 45 caracteres.",
                },
                fecha_publicacion: {
                    required: "Ingrese la fecha de publicación."
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
                doi: {
                    regex: "El campo no contiene un DOI válido."
                },
                fecha_evento: {
                    required: "Ingrese la fecha del evento."
                },
                ISSN_ISBN: {
                    regex: "El ISBN o ISSN ingresado no es correcto."
                },
            },
            submitHandler: function (form) {
                form.submit();
                $("#boton-guardar").attr("disabled", true);
            }
        });
    });
</script>