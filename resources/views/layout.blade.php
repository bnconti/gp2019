<?php

use Illuminate\Support\Facades\Session;
$user = Session::get('user');
$isAdmin = false;
$userId = '';

if (!empty($user)) {
    $isAdmin = $user->es_admin;
    $userId = $user->id;
    $output = Session::get('first_name');
} else {
    // TODO: Hacer que la authURL sea configurable
    $authUrl = 'http://localhost:8000/login/google';
    $output = '<a href="' . filter_var($authUrl, FILTER_SANITIZE_URL) . '"><img src="storage/images/sign-in-button.png"/></a>';
}

if ($user['aceptado'] == 0) {
    header("Location: http://localhost:8000/locked");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <html lang="es">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("titulo")</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- CSS del sitio -->
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet" type="text/css" />

    <!-- CSS de las tablas -->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <!-- Unas fuentes -->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Roboto+Slab:700" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.themes.min.css') }}">

    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</head>

<body>
    <div id="container">
        <div id="navbar">
            <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="/proyectos">SIGAA</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContenido"
                    aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContenido">
                    <ul class="nav navbar-nav mr-auto">

                        @if ($isAdmin)
                        <li class="nav-item" visible="{{$isAdmin?'visible':'hidden'}}">
                            <a class="nav-link" href="/usuarios"><i class="fas fa-users fa-fw"></i>Usuarios</a>
                        </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-project-diagram fa-fw"></i>Proyectos
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route("proyectos.index") }}"><i
                                        class="fas fa-eye fa-fw"></i>Ver lista de Proyectos</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route("proyectos.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar Proyecto</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-book fa-fw"></i>Publicaciones
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route("publicaciones") }}"><i
                                        class="fas fa-eye fa-fw"></i>Ver
                                    lista de Publicaciones</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route("tesisTesina.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar tesis o tesina</a>
                                <a class="dropdown-item" href="{{ route("articuloRevista.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar artículo para revista</a>
                                <a class="dropdown-item" href="{{ route("trabajoEvento.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar trabajo para evento</a>
                                <a class="dropdown-item" href="{{ route("libro.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar libro</a>
                                <a class="dropdown-item" href="{{ route("parteLibro.create") }}"><i
                                        class="fas fa-file-upload fa-fw"></i>Cargar parte de libro</a>
                            </div>
                        </li>

                        @if ($isAdmin)
                        <li class="nav-item">
                            <a class="nav-link" href="/reportes"><i class="fas fa-file-pdf fa-fw"></i>Reportes</a>
                        </li>
                        @endif

                    </ul>
                </div>

                <ul class="nav navbar-nav navbar-right navbar-custom">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="usuarioDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fas fa-user fa-fw"></i> <?php echo $output; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usuarioDropdown">
                            <a class="dropdown-item" href="{{ route("usuarios.edit", $userId ) }}">
                                <i class="fas fa-user-cog fa-fw"></i>Panel de usuario</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="http://localhost:8000/logout">
                                <i class="fas fa-sign-out-alt fa-fw"></i>Cerrar sesión</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="container" id="main">
            @yield("content")
        </div>
        <div id="footer">
            <div class="footer">Aplicación web desarrollada por estudiantes de la <a
                    href="https://www.unnoba.edu.ar/"><strong>UNNOBA</strong></a>.
            </div>
        </div>
    </div>

    <!-- Font Awesome 5 -->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

    <!-- Ajax -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <!-- Aca va lo requerido para autocompletado -->
    <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript" charset="utf8">
    </script>

    <script src=" {{ asset('js/jquery.validate.js') }}"></script>

    @stack('scripts')

</body>

</html>