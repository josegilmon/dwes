<?php

require "../vendor/autoload.php";


use Tarea\Operaciones;

$operaciones = new Operaciones();
echo "PVP 3DS: " . $operaciones->getPVP(3);

?>