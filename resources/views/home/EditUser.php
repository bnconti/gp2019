<?php
//session_start();
// Include User library file
require_once 'User.class.php';
// Initialize User class
use Illuminate\Support\Facades\Session;
use App\Modelos\Persona;

$user = new User();
$userToModify = Session::get('user');

// Modificar la base de datos del usuario
$UserData = array();
$UserData['mail_itt'] = $_GET['email'];
$UserData['rol'] = $_GET['rol'];
$UserData['cargo'] = $_GET['cargo'];
$UserData['dedicacion'] = $_GET['dedicacion'];
$matchGmail = Session::get('user')['gmail'];
$user->setUserLocal($UserData, $matchGmail);

// Crear persona desde pop-up
$persona = new Persona();
$apellido = $_GET['apellido'];
$nombre = $_GET['nombre'];
$dni = $_GET['dni'];
$persona->crear($apellido,$nombre,$dni);

// Modificar session del usuario
$userToModify['mail_itt'] = $_GET['email'];
$userToModify['rol'] = $_GET['rol'];
$userToModify['cargo'] = $_GET['cargo'];
$userToModify['dedicacion'] = $_GET['dedicacion'];
Session::put('user', $userToModify);
Session::save();

header('Location: http://localhost:8000/inicio2');
exit;

?>