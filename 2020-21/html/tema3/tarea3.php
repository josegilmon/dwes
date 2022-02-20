<?php

$conProyecto = new mysqli('localhost', 'gestor', 'Secret0.', 'proyecto');
$error = $conProyecto->connect_errno;
if ($error != null) {
    $resultado = $conProyecto->query("SELECT * FROM productos");
    $producto = $resultado->fetch_array();
    while ($producto != null) {
        echo $producto["nombre"].": ".$producto["descripcion"];
    }
    $conProyecto->close(); //cerramos la conexion
}

?>