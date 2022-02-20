<?php

use App\Jugador;

session_start();

require "../vendor/autoload.php";
require_once "datos.php";

for ($i = 0; $i < 20; $i++) {
    // Para evitar errores por duplicados a la hora de crear el dorsal, se lo pasamos como parámetro
    $jugador = Jugador::creaJugador($i + 1);
    $jugador->persiste($bd);
}

header("Location: jugadores.php");
