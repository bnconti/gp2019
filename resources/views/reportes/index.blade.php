@extends("layout")

@section("titulo", "SIGAA - Reportes")

@section("content")
    
    <script>
    
    </script>
    
    <div class="card">
        <h5 class="card-header">Reportes</h5>
        <div class="card-body">
            <table class="table table-borderless" id="tabla-proyectos" style="margin-top: -30px;">
                <tr>
                    <td style= "border-bottom: 2px solid #e9ecef">
                        
                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between">
                            <div class="p-2 bd-highlight"> 
                                <p>Seleccione a un autor para ver los proyectos y/o publicaciones en los que se encuentra trabajando.</p>
                            </div>
                            
                            <div class="p-2 bd-highlight">
                                <select class="custom-select" id="autor" style= "width: 267px">
                                    <option value="0" selected>-- Seleccione Autor --</option>
                                    @foreach($autores as $autor)
                                    <option value="{{$autor->id}}">{{$autor->apellido}}, {{$autor->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            
                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between" style="display:none !important; height: 120px;">
                            <div class="p-2 bd-highlight">
                                <p>Ingrese un rango de fechas para acotar la busqueda.</p>
                            </div>
                            <div class="d-flex p-2 bd-highlight flex-column">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Desde:</span>
                                    </div>
                                    <input type="date" class="form-control" aria-describedby="basic-addon1" id="desde">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Hasta: <span style="color:#e9ecef">.</span> </span>
                                    </div>
                                    <input type="date" class="form-control" aria-describedby="basic-addon1" id="hasta">
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>

                <tr>
                    <td style= "border-bottom: 2px solid #e9ecef">
                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between">
                            <div class="p-2 bd-highlight">
                                <p>Elija una opción para realizar una descripción del proyecto seleccionado del autor.</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <select class="custom-select" id="tipo-proyecto" style= "width: 267px">
                                    <option value="0" selected>-- Seleccione Tipo --</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between">
                            <div class="p-2 bd-highlight">
                            </div>
                            <div class="d-flex p-2 bd-highlight flex-column">
                                <div class="input-group mb-3">
                                    <button id="listadoProyectos" disabled class="form-control btn btn-info">Listado Proyectos</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style= "border-bottom: 2px solid #e9ecef">
                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between">
                            <div class="p-2 bd-highlight">
                                <p>Elija un tipo de publicación a buscar.</p>
                            </div>
                            <div class="p-2 bd-highlight">
                                <select class="custom-select" id="tipo-publicacion" style= "width: 267px">
                                    <option value="0" selected>-- Seleccione Tipo --</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-flex p-2 bd-highlight flex-row justify-content-between">
                                <div class="p-2 bd-highlight">
                                </div>
                                <div class="d-flex p-2 bd-highlight flex-column">
                                    <div class="input-group mb-3">
                                        <button id="listadoPublicaciones" disabled class="form-control btn btn-info">Listado Publicaciones</button>
                                    </div>
                                </div>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="text-center m-3">
                            <h5>Seleccione elemento</h5>
                        </div>
                        <div class="list-group" id="listaDeElementos">
                            {{-- <button type="button" class="list-group-item list-group-item-action">Dapibus ac facilisis in</button> --}}
                            <a role="button" disabled class="list-group-item list-group-item-action">No hay coincidencias</a>

                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex justify-content-center" style="color:white">
                            <button id="generadorReporte" class="btn btn-info" disabled role="button">Generar Reporte</button>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="form-group">
                <label for="comment">Resumen:</label>
                <textarea class="form-control" rows="5" id="resumenGenerado">Nada de momento</textarea>
            </div>
            <div class="form-group">
                <button id="copiarResumen"  type="button" class="btn btn-danger"> <i class="far fa-copy"></i> Copiar al portapapeles</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>

    var seleccionProyecto;
    var seleccionPublicacion;
    var id; //id persona
    var idElemento; //id proyecto seleccionado en la lista
    var buscamos; //definimos si es proyecto, publicacion, articulo , etc.
    var tipo_proyecto; //para cuando lo necesitamos, tenemos el tipo de proyecto sea investigacion, extension, etc.
    var texto=$('#resumenGenerado').text();

    $("#autor").change(function(){
        id = $(this).val();
        //vaciamos el segundo combo para asegurarnos que no queden tipos anteriores        
        $('#tipo-proyecto').find('option').not(':first').remove();
        $('#tipo-publicacion').find('option').not(':first').remove();

        /* var fechaInicio = new Date ($('#desde').val());
        var fechaFin = new Date ($('#hasta').val()); */

        // AJAX request para conseguir todos los tipo de proyectos asociados a una persona 
        $.ajax({
           url: 'getProyectosTipo/'+id,
           type: 'get',
           dataType: 'json',
           success: function(response){
             var len = 0;
             if(response['data'] != null){
               len = response['data'].length;
                $("#tipo-publicacion").append( "<option value=libros>Libros</option>" ); 
                $("#tipo-publicacion").append( "<option value=revistas>Revistas</option>" ); 
                $("#tipo-publicacion").append( "<option value=grado>Grado</option>" ); 
                $("#tipo-publicacion").append( "<option value=grado>Posgrado</option>" ); 
                $("#tipo-publicacion").append( "<option value=congresos>Congresos</option>" ); 
             }

             if(len > 0){
               for(var i=0; i<len; i++){
                    var tipoProy = response['data'][i].tipo_proyecto;
                    var option = "<option value='"+tipoProy+"'>"+tipoProy+"</option>"; 
                    $("#tipo-proyecto").append(option); 
               }
                var final = "<option value=all>- Todo -</option>"; 
                $("#tipo-proyecto").append(final); 
             }else{
                $("#tipo-proyecto").append("<option disabled value=-11>Sin resultados</option>"); 
             }
           }
        });
    });

    //detectamos cambio sobre el tipo de proyecto
    $("#tipo-proyecto").change(function(){
        seleccionProyecto = $(this).val();
        var validado = true;
        if (seleccionProyecto != 0){
            validado=false;
        }else{
            validado=true;
        }
        $('#listadoProyectos').prop('disabled',validado);
    });

    //este es para el dropdown de las publicaciones 
    $("#tipo-publicacion").change(function(){
        seleccionPublicacion = $(this).val();
        var validado2 = true;
        if (seleccionPublicacion != 0){
            validado2=false;
        }else{
            validado2=true;
        }
        $('#listadoPublicaciones').prop('disabled',validado2);
    });

    $('#listadoProyectos').click(function () {
        
        $('#listaDeElementos').empty();

        //Armamos otro Ajax request para traernos todos los proyectos segun correspond
        $.ajax({
           url: 'poblarElementosSegunProyecto/'+id+'/'+seleccionProyecto,
           type: 'get',
           dataType: 'json',
           success: function(response){
             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }
             if(len > 0){
                $('#generadorReporte').prop('disabled',true);
                for(var i=0; i<len; i++){
                    var idPub = response['data'][i].id;
                    var titulo = response['data'][i].titulo;
                    tipo_proyecto = response['data'][i].tipo_proyecto;
                    var item ='<a id-elemento='+idPub+' buscando="proyectos" role="button" class="elementoLista list-group-item list-group-item-action">'+tipo_proyecto+" | "+titulo+'</a>';
                    $('#listaDeElementos').append(item);
                }
             }else{
                var item ='<button role="button" disabled class="list-group-item list-group-item-action"> No hay coincidencias</button>';
                $('#listaDeElementos').append(item);
             }
           }
        });
    });
    ///////////////////////////////////////////////////////

    $('#listadoPublicaciones').click(function () {
        
        $('#listaDeElementos').empty();

        //Armamos otro Ajax request para traernos todo según corresponda
        $.ajax({
           url: 'poblarElementosSegunPublicacion/'+id+'/'+seleccionPublicacion,
           type: 'get',
           dataType: 'json',
           success: function(response){
             var len = 0;
             if(response['data'] != null){
                len = response['data'].length;
             }
             if(len > 0){
                $('#generadorReporte').prop('disabled',true);
                for(var i=0; i<len; i++){
                    var idPub = response['data'][i].publicaciones_id;
                    var titulo = response['data'][i].titulo;
                    var item ='<a id-elemento='+idPub+' buscando="'+seleccionPublicacion+'" role="button" class="elementoLista list-group-item list-group-item-action">'+titulo+'</a>';
                    $('#listaDeElementos').append(item);
                }
             }else{
                var item ='<button role="button" disabled class="list-group-item list-group-item-action"> No hay coincidencias</button>';
                $('#listaDeElementos').append(item);
             }
           }
        });
    });






    ///////////////////////////////////////////////////////
    $(document).on('click', '.elementoLista', function () {
        idElemento = $(this).attr('id-elemento');
        buscamos = $(this).attr('buscando');

        // If this isn't already active
        if (!$(this).hasClass("active")) {
            // Remove the class from anything that is active
            $(".list-group-item-action.active").removeClass("active");
            // And make this active
            $(this).addClass("active");
        } 
        $('#generadorReporte').prop('disabled',false);
    });

    $('#generadorReporte').click(function () {
        var url;
        var urlPersonalizada;
        switch(buscamos) {
            case 'proyectos':
                if (tipo_proyecto == 'Extensión'){
                    urlPersonalizada = 'personaProyectoExtension/';
                }else{
                    urlPersonalizada = 'personaProyectosVarios/';
                }
                url = urlPersonalizada +id+'/'+idElemento; //id es el autor/director y idElem es id de proy, art, libro, etc.
                console.log("Tipo de proyecto: "+tipo_proyecto);
                break;
            case 'revistas':
                url = 'personaArtRevista/' +id+'/'+idElemento; //id es el autor o director y idElemento seria el id de la publicaciones_id en este caso
                break;
                case 'libros':
                url = 'personaLibro/' +id+'/'+idElemento; //id es el autor o director y idElemento seria el id de la publicaciones_id en este caso
                break;
            case 'grado':
                url = 'personaGrado/' +id+'/'+idElemento; //id es el autor o director y idElemento seria el id de la publicaciones_id en este caso
                break;
            case 'congresos':
                url = 'personaCongresos/' +id+'/'+idElemento; //id es el autor o director y idElemento seria el id de la publicaciones_id en este caso
                break;
            default:
                // code block
        }

        // buscamos el cruce entre persona y lo que este seleccionado
        $.ajax({
           url: url,
           type: 'get',
           dataType: 'json',
           success: function(response){
                var len = 0;
                if(response['data'] != null){
                len = response['data'].length;
                }
                if(len > 0){    
                    switch(buscamos) {
                        case 'proyectos':

                            if (tipo_proyecto == 'Extensión'){
                                /* Cáritas Digital (EXP. 2701/17)
                                Dirige: López Gil, Fernando
                                Resolución (CS) 1383/2017 */
                                console.log($(response['data']));
                                texto=  response['data'][0].titulo + ' (EXP. '+ response['data'][0].expediente+') \n'+
                                        'Dirige: '+response['data'][0].apellido+', '+response['data'][0].nombre+' \n'+
                                        'Resolución (CS) '+response['data'][0].resolucion;
                            }else{
                                /**
                                 *  2019, Informática y Tecnologías Emergentes, Acreditado y Financiado por UNNOBA con evaluación externa en el marco de la convocatoria a Subsidios de Investigación Bianuales (SIB 2019), Resolución CS 1623/2019 – Exp. 548/2019 (continuación del proyecto anterior).
                                    Dirige: Mg. Claudia Russo
                                    Codirige: Lic. Mónica Sarobe
                                 */
                                var datos = $(response['data'][0]);
                                var texto= datos[0].expediente.substr(-4)+ ', '+datos[0].titulo+', Acreditado y Financiado por UNNOBA con evaluación externa en el marco de la convocatoria a Subsidios de Investigación Bianuales (SIB '+datos[0].expediente.substr(-4)+'), Resolución CS '+datos[0].resolucion+' - Exp. '+datos[0].expediente+'. \n'+
                                            'Dirige: '+datos[0].dirnombre+' '+datos[0].dirapellido+'\n'+
                                            'Codirige: '+datos[0].conombre+' '+datos[0].coapellido+'\n';
                            }
                            break;
                        case 'revistas':

                            /**Russo, C.; Sarobe, M.; Esnaola, L.; Alonso, N. “Entornos Virtuales 3D, una propuesta educativa innovadora”
                             en Revista Científica Iberoamericana de Tecnología Educativa, pag. 32-42. ISSN: 2255-1514.
                            Huelva (Spain), vol. IV; nº 01 1º semestre, marzo de 2015. 
                            Disponible en: http://www.uajournals.com/campusvirtuales/images/numeros/6.pdf. */
                            var datos = $(response['data'][0]);
                            var autores = $(response['autores']);
                            len = autores.length;
                            if(len > 0){
                                for(var i=0; i<len; i++){
                                    if (i!=len){
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'.; ';
                                    }else{
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'. ';
                                    }
                                }
                            }
                            texto += '"'+datos[0].titulo+'". ';
                            texto += 'en '+datos[0].titulo_revista;
                            
                            if (datos[0].pag_inicial){
                                texto+=', pag.'+datos[0].pag_inicial+'-'+datos[0].pag_final+'.';
                            }
                                texto += ' ISSN:'+datos[0].issn+'.\n';
                            if (datos[0].ciudad_edicion){
                                texto+=datos[0].ciudad_edicion+' ('+datos[0].pais_edicion+'), ';
                            }
                            if (datos[0].volumen){
                                var fecha = new Date(datos[0].fecha_publicacion);
                                var options = {year: 'numeric', month: 'long' };

                                texto+='vol. '+datos[0].volumen+'; n° '+datos[0].numero+', '+fecha.toLocaleDatestring("es-ES",options);
                            }
                            if (datos[0].url){
                                texto+='\nDisponible en: '+datos[0].url;
                            }
                            break;
                        case 'libros':

                            /**Esnaola, L.; Alonso, N.; Domínguez, D. “Experiencias: modelo de acompañamiento, tutorización y evaluación en las
                             *  modalidades presencial y semipresencial del ingreso a la universidad”. 
                             * TIC ACTUALIZADAS PARA UNA NUEVA DOCENCIA UNIVERSITARIA. 
                             * McGraw-Hill Interamericana de España, S.L. ISBN: 978-84-48612-65-8. Cap. 16. (2016). */
                            var datos = $(response['data'][0]);
                            var autores = $(response['autores']);
                            
                            len = autores.length;
                            if(len > 0){
                                for(var i=0; i<len; i++){
                                    if (i!=len){
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'.; ';
                                    }else{
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'. ';
                                    }
                                }
                            }
                            texto += '"'+datos[0].titulo+'". ';
                            if (datos[0].resumen){
                                texto=datos[0].resumen+'. ';
                            }
                            texto += datos[0].editorial+', S.L. ISBN: '+datos[0].ISBN+'. ('+datos[0].fecha_publicacion.substr(0,4)+').';
                            break;
                        case 'grado':

                            /**grado - N personas
                            Serrano, E., & Russo, C., & Zurera, M. (2018) Generación de Píldoras Educativas Inclusivas. 
                            (Tesina de grado). ISBN: en trámite. Universidad Nacional del Noroeste de Buenos Aires, Escuela de Tecnología.
                             */
                            var datos = $(response['data'][0]);
                            var autores = $(response['autores']);
                            len = autores.length;
                            if(len > 0){
                                for(var i=0; i<len; i++){
                                    if (i!=len){
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'., & ';
                                    }else{
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'. ';
                                    }
                                }
                            }                            
                            texto += ' ('+datos[0].fecha_publicacion.substr(0,4)+') ';
                            texto += ''+datos[0].titulo+'. ('+datos[0].titulo_obtenido+'). ISBN: '+datos[0].doi+'. '+datos[0].institucion;
                            break;
                        case 'congresos':
                            /**
                            congresos - N personas
                            Esnaola, L., Tessore, J., Ramón, H. (2018) Detección automática de emociones mediante algoritmos inteligentes. 
                            I Congreso Multidisciplinario de la UNNOBA: Ciencia, Innovación y Sociedad.
                             */
                            var datos = $(response['data'][0]);
                            var autores = $(response['autores']);
                            len = autores.length;
                            if(len > 0){
                                for(var i=0; i<len; i++){
                                    if (i!=len){
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'., ';
                                    }else{
                                        texto+= autores[i].apellido +', '+autores[i].nombre.substring(0,1)+'. ';
                                    }
                                }
                            }    
                            texto += ' ('+datos[0].fecha_publicacion.substr(0,4)+') ';
                            texto += ''+datos[0].titulo+'. '+datos[0].nombre_evento+'.';                        
                             break;
                        default:
                    }
                    $('#resumenGenerado').text(texto+'\n');
                }else{
                    console.log("Respuesta vacia");
                }
           }
        });
    });
    $('#copiarResumen').click(function () {
        $('#resumenGenerado').select();
        document.execCommand("copy");
        alert("Copiado al portapapeles: ");
    });
</script>

@endpush