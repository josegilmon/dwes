<?php

session_start();

require "../vendor/autoload.php";
require_once "datos.php";

use App\Datos;
use App\Jugador;

$error = "";
$nombre = leerCampo("nombre");
$apellidos = leerCampo("apellidos");
$dorsal = leerCampo("dorsal");
$posicion = leerCampo("posicion");
$barcode = leerCampo("codigoBarras");
$datos = ["nombre" => $nombre, "apellidos" => $apellidos, "dorsal" => $dorsal ? intval($dorsal) : null, "posicion" => $posicion, "barcode" => $barcode];

if (isset($_POST["crear"])) {

    if (empty($nombre)) {
        $error = "El nombre no puede estar vacío";
    } elseif(empty($apellidos)) {
        $error = "El apellido no puede estar vacío";
    } elseif(empty($barcode)) {
        $error = "El código de barras no puede estar vacío";
    } else {
        if(!empty($dorsal)) {
            $jugador = Jugador::recuperaJugadorPorDorsal($bd, $dorsal);
            if ($jugador !== null) {
                $error = "Ya existe un jugador con este dorsal";
            }
        }
        $jugador = Jugador::recuperaJugadorPorBarcode($bd, $barcode);
        if ($jugador !== null) {
            $error = "Ya existe un jugador con este código de barras";
        }
    }
    if (empty($error)) {
        try {
            $jugador = new Jugador($nombre, $apellidos, $dorsal ? intval($dorsal): null, $posicion, $barcode);
            $jugador->persiste($bd);        
            // limpiamos los campos del formulario
            // $datos = ["nombre" => "", "apellidos" => "", "dorsal" => "", "posicion" => "", "barcode" => ""];

            header("Location: jugadores.php?creado=true");

        } catch (PDOException $error) {
            //$error = "Error al guardar los datos del jugador";
            die($error);
        }
    }
}
if (isset($_POST["limpiar"])) {
    $datos = ["nombre" => "", "apellidos" => "", "dorsal" => "", "posicion" => "", "barcode" => ""];
}
if (isset($_POST["volver"])) {
    header("Location: jugadores.php");
}
if (isset($_POST["barcode"])) {
    $barcode = $faker->ean13();
    $datos["barcode"] = $barcode;
}

$posiciones = Datos::POSICIONES;

echo $blade->run('formjugador', compact('posiciones', 'datos', 'error'));
