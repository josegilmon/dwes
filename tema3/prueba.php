<?php

$host = "localhost";
$db = "proyecto";
$user = "root";
$pass = "";

// MySQLi
$conProyecto = new mysqli($host, $user, $pass, $db);
$error = $conProyecto->connect_errno;

echo "<label>MySQLi</label>";
echo "<ul>";
if ($error == null) {
    $resultado = $conProyecto->query("SELECT * FROM productos");
    
    while ($producto = $resultado->fetch_array()) {
        echo "<li>".$producto["nombre"].": ".$producto["pvp"]."</li>";
        // $producto = $resultado->fetch_array();
    }
    $conProyecto->close(); //cerramos la conexion
} else {
    echo "<li>Se produjo un error al recuperar los productos</li>";
}
echo "</ul>";

// PDO
$dsn = "mysql:host=$host;dbname=$db";
$conProyecto=new PDO($dsn, $user, $pass);

$resultado = $conProyecto->query("SELECT * FROM familias");

echo "<label>PDO</label>";
echo "<ul>";
while ($familia = $resultado->fetch()) {
    echo "<li>".$familia["cod"].": ".$familia["nombre"]."</li>";
    // $producto = $resultado->fetch_array();
}
echo "</ul>";

?>