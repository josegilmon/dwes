<?php
$url="http://localhost/dwes/soap/soap-server.php";
$uri="http://localhost/dwes/soap";
$cliente = new SoapClient(null,array('location'=>$url,'uri'=>$uri));

$suma = $cliente->suma(2,7);
$resta = $cliente->resta(9,3);
print("La suma es ".$suma);
print("La resta es ".$resta);
?>