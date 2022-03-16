<?php

require '../vendor/autoload.php';
 
use PHP2WSDL\PHPClass2WSDL;

$class = "Tarea\\Operaciones";
$serviceURI = "http://dwes/tema6/tarea/servidorSoap/servicioW.php";
$wsdlGenerator = new PHPClass2WSDL($class, $serviceURI);
// Generate the WSDL from the class adding only the public methods that have @soap annotation.
$wsdlGenerator->generateWSDL(true);
// Dump as string
$wsdlXML = $wsdlGenerator->dump();
// Or save as file
$wsdlXML = $wsdlGenerator->save('../servidorSoap/servicio.wsdl');

?>