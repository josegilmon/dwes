<?php

$host = "localhost";
$db = "proyecto";
$user = "root";
$pass = "";

// PDO
$dsn = "mysql:host=$host;dbname=$db";
$conProyecto=new PDO($dsn, $user, $pass);

?>