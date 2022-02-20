<?php

session_start();

require "../vendor/autoload.php";
require_once "datos.php";

$mensaje = null;
if (isset($_GET["creado"])) {
    $mensaje = "Jugador creado con éxito";
}

echo $blade->run('jugadores', compact('jugadores', 'barcode', 'mensaje'));
