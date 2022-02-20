<?php
session_start();

require "../vendor/autoload.php";

use eftec\bladeone\BladeOne;
use App\BD;
use App\Usuario;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new BladeOne($views, $cache);

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    die("Error en la conexión con la BD");
}

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['usuario']);
}
else if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario'];
    echo $blade->run("portada", compact('nombreUsuario'));
    die;
    header('Location:listado.php');
} else if (isset($_POST['login'])) {
    $nombreUsuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING));
    $errorLoginForm = strlen($nombreUsuario) === 0 || strlen($pass) === 0;
    if (!$errorLoginForm) {
        $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $nombreUsuario, $pass);
        $errorCredenciales = is_null($usuario);
        if (!$errorCredenciales) {
            $_SESSION['usuario'] = $nombreUsuario;
            echo $blade->run("portada", compact('nombreUsuario'));
            die;
        } else {
            echo $blade->run("login", compact('errorCredenciales'));
            die;
        }
    } else {
        echo $blade->run("login", compact('errorLoginForm', 'nombreUsuario', 'pass'));
        die;
    }
}

echo $blade->run("login");
