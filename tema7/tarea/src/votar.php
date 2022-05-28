<?php

session_start();

require "../vendor/autoload.php";

use App\BD;
use App\Voto;


// Comprobamos que el usuario tiene una sesión válida
if (isset($_SESSION["usuario"])) {
    $idUs = $_SESSION["usuario"];
} else {
    throwError("Invalid session", 401);
}

// Comprobamos que se han enviado correctamente los parámetros esperados
if (!empty($_POST) && isset($_POST["idPr"]) && isset($_POST["cantidad"])) {
    $idPr = filter_input(INPUT_POST, "idPr", FILTER_SANITIZE_STRING);
    $cantidad = filter_input(INPUT_POST, "cantidad", FILTER_SANITIZE_STRING);

    miVoto($idUs, $idPr, $cantidad);
}

function miVoto(string $idUs, int $idPr, int $cantidad) {
    try {
        $bd = BD::getConexion();
    } catch (PDOException $error) {
        die("Error en la conexión con la BD");
    }
    
    $voto = new Voto($idPr, $idUs, $cantidad);

    // Comprobamos que el usuario no haya votado ya
    if ($voto->compruebaVotoPorProductoUsuario($bd) != null) {
        $result = false;
    } else {
        // Guardamos el voto del usuario
        $voto->persiste($bd);
        // Obtenemos la valoración media del producto
        $valoracion = Voto::recuperaValoracionMediaPorProducto($bd, $idPr);
        if ($valoracion != null && $valoracion->getCantidad() != null) {
            $result = $valoracion->getCantidad();
        } else {
            // nunca debería pasar por aquí, porque justo acabamos de guardar una valoración
            $result = 0;
        }
    }

    $response = compact('result');
    header('Content-type: application/json');
    echo json_encode($response);
    die;    
}

function pintarEstrellas() {

}

function throwError(string $errorMessage, int $errorCode) {
    $response = compact('errorMessage');
    header('Content-type: application/json');
    http_response_code($errorCode);
    echo json_encode($response);
    die;    
}

?>