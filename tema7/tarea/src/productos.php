<?php

session_start();

require "../vendor/autoload.php";

use eftec\bladeone\BladeOne;
use App\BD;
use App\Producto;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new BladeOne($views, $cache);

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    die("Error en la conexión con la BD");
}

if (isset($_SESSION['usuario'])) {
    $nombreUsuario = $_SESSION['usuario'];
    try {
        $productos = Producto::recuperaProductos($bd);
    } catch (PDOException $ex) {
        die("Error al recuperar los productos " . $ex->getMessage());
    }
    echo $blade->run('productos', compact('nombreUsuario', 'productos'));
} else {
    echo $blade->run('login');
}