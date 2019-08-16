<?php
//session_start();
// Include User library file
//require_once 'User.class.php';
use Illuminate\Support\Facades\Session;
$user = Session::get('user');
$persona = Session::get('persona');

?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuario Bloqueado</title>
    <link href="css/popup.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div>
        <div style="text-align:center">
        <h2> Su usuario aún se encuentra en espera de ser aceptado, por favor intente mas tarde. </h2>
            <p><a href="http://localhost:8000/logout">Volver</a></p>
        </div>
        <br>
        <br>
    </div>

        <!--
        <div style="text-align:center">
            <button type="submit" class="open-button" onclick="openForm()">Modificar datos de usuario</button>
        </div>
        <div class="form-popup" id="UserForm">
        <form action="http://localhost:8000/editUser" class="form-container" method="get">
            <h1>Datos de usuario</h1>

            <input type="hidden" name="userId" value="<?php echo $user['id'] ?>">

            <label for="email"><b>ITT Email</b></label>
            <input type="text" value="<?php echo $user['mail_itt']; ?>" name="email" required>

            <label for="rol"><b>Rol</b></label>
            <input type="text" value="<?php echo $user['rol']; ?>" name="rol" required>

            <label for="cargo"><b>Cargo</b></label>
            <input type="text" value="<?php echo $user['cargo']; ?>" name="cargo" required>

            <label for="dedicacion"><b>Dedicación</b></label>
            <input type="text" value="<?php echo $user['dedicacion']; ?>" name="dedicacion" required>

            <label for="nombre"><b>Nombre</b></label>
            <input type="text" placeholder="Ingrese nombre..." value="<?php echo $persona['nombre']; ?>" name="nombre" required>

            <label for="apellido"><b>Apellido</b></label>
            <input type="text" placeholder="Ingrese apellido..." value="<?php echo $persona['apellido']; ?>" name="apellido" required>

            <label for="dni"><b>CUIL/CUIT</b></label>
            <input type="text" placeholder="Ingrese cuil/cuit..." value="<?php echo $persona['cuit_cuil']; ?>" name="dni" required>

            <button type="submit" class="btn">Guardar</button>
            <button type="submit" class="btn cancel" onclick="closeForm()">Cerrar</button>
        </form>
    </div>

    <script>
        function openForm() {
        document.getElementById("UserForm").style.display = "block";
        }

        function closeForm() {
        document.getElementById("UserForm").style.display = "none";
        }
    </script>
    -->
</body>
</html>