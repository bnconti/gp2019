<?php
// Include configuration file
require_once 'config.php';

// Include User library file
require_once 'User.class.php';

if (isset($_GET['code'])) {
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var(GOOGLE_REDIRECT_URL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    // TODO: cambiar inicio 2 por inicio despues de cambiar el callback de google
    $output = header('Location: http://localhost:8000/inicio2');exit;
    /*
// Get user profile data from google
$gpUserProfile = $google_oauthV2->userinfo->get();

// Initialize User class
$user = new User();

// Getting user profile info
$gpUserData = array();
$gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
$gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
$gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
$gpUserData['email']      = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
$gpUserData['gender']     = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
$gpUserData['locale']     = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
$gpUserData['picture']    = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
$gpUserData['link']       = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';

// Insert or update user data to the database
$gpUserData['oauth_provider'] = 'google';
$userData = $user->checkUser($gpUserData);

// Storing user data in the session
$_SESSION['userData'] = $userData;

// Render user profile data
if(!empty($userData)){
$output  = '<h2>Google Account Details</h2>';
$output .= '<div class="ac-data">';
$output .= '<img src="'.$userData['picture'].'">';
$output .= '<p><b>Google ID:</b> '.$userData['oauth_uid'].'</p>';
$output .= '<p><b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'</p>';
$output .= '<p><b>Email:</b> '.$userData['email'].'</p>';
$output .= '<p><b>Gender:</b> '.$userData['gender'].'</p>';
$output .= '<p><b>Locale:</b> '.$userData['locale'].'</p>';
$output .= '<p><b>Logged in with:</b> Google</p>';
$output .= '<p><a href="'.$userData['link'].'" target="_blank">Click to visit Google+</a></p>';
$output .= '<p>Logout from <a href="http://localhost:8000/logout">Google</a></p>';
$output .= '</div>';
}else{
$output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
}*/
} else {
    // Get login url
    //    $authUrl = $gClient->createAuthUrl();
    // TODO: Hacer que la authURL sea configurable
    $authUrl = 'http://localhost:8000/login/google';

    // Render google login button
    $output = '<a href="' . filter_var($authUrl, FILTER_SANITIZE_URL) . '"><img src="storage/images/sign-in-button2.png"/></a>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login SIGAA</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        img {
        position: absolute;
        top: 40%;
        left: 20%;
        }

        #logo {
        border-radius: 20%;
        display: block;
        position: static;
        margin-left: auto;
        margin-right: auto;
        object-fit: cover;
        }
    </style>
</head>
<body>
    <?php if ($message = Session::get('exito')): ?>
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert"aria-label="cerrar">
                    <span aria-hidden="true">&times;</span>
            </button>
            <strong><i class="fas fa-check-circle fa-fw"></i><?php echo $message ?></strong>
        </div>
    <?php endif;?>

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img src="logo.png" alt="Logo" id="logo">
                <br>
                <div class="card">
                    <div class="card-header">Bienvenido</div>
                    <div class="card-body">
                        Bienvenido al <strong>SIGAA</strong> (<em>Sistema de Gestión de Antecedentes Académicos</em>), elija un método para ingresar o cree una nueva cuenta.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Usuario Local</div>

                    <div class="card-body">
                        <?php if ($message = Session::get('error')): ?>
                            <div class="alert alert-error">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="fas fa-check-circle fa-fw"></i><span style="color:red"><?php echo $message ?></span></strong>
                            </div>
                        <?php endif;?>

                        <form method="POST" action="/login">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email académico</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>

                            <br>

                            <div class="text-center">
                                <p>¿No tiene una cuenta local? <a href="/usuarios/create">Registrarse</a>.</p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Usuario de Google</div>
                    <div class="col-md-4">
                        <!-- Display login button / Google profile information -->
                        <?php echo $output; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>