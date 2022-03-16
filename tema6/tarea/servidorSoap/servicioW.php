<?php

require '../vendor/autoload.php';

use Tarea\Operaciones;

$uri = 'http://dwes/tema6/tarea/servidorSoap';
$parametros = ['uri' => $uri];
try {
    $server = new SoapServer("http://dwes/tema6/tarea/servidorSoap/servicio.wsdl");
    $server->setClass(Operaciones::class);
    $server->handle();
} catch (SoapFault $f) {
    die("error en server: " . $f->getMessage());
}

?>