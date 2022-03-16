<?php

$url = "http://dwes/tema6/tarea/servidorSoap/servicio.wsdl";

$paramPVP = ['codigo' => 4];
$param = ['a' => 51, 'b' => 29];

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $ex) {
    echo "Error: ".$ex->getMessage();
}

$pvp = $cliente->__soapCall('getPVP', $paramPVP);

// $resta=$cliente->__soapCall('resta', $param);

echo "El precio de la Nintendo 3DS es: $pvp";

?>