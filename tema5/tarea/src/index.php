<?php

session_start();

require "../vendor/autoload.php";
require_once "datos.php";

if (empty($jugadores)) {
    echo $blade->run('instalacion');
} else {
    header("Location: jugadores.php");
}