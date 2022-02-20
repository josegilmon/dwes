<?php

require "../vendor/autoload.php";

use App\BD;
use App\Datos;
use App\Jugador;
use Faker\Factory;
use Milon\Barcode\DNS1D;
use eftec\bladeone\BladeOne;

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
define("BLADEONE_MODE", 1); // (optional) 1=forced (test),2=run fast (production), 0=automatic, default value.
$blade = new BladeOne($views, $cache);

$barcode = new DNS1D();
$barcode->setStorPath($cache);

$faker = Factory::create('es_ES');

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    die("Error en la conexión con la BD");
}

try {
    $jugadores = Jugador::recuperaJugadores($bd);
} catch (PDOException $ex) {
    die("Error al recuperar los jugadores " . $ex->getMessage());
}

function leerCampo(string $campo) : string {
    return isset($_POST[$campo]) ? $_POST[$campo] : "";
}

?>