<?php
require_once("Calcula.php");
// Ruta a WSDLDocument
require_once("WSDLDocument.php");

$wsdl = new WSDLDocument(
    "Calcula", 
    "http://localhost/dwes/soap/soap-server.php", 
    "http://localhost/dwes/soap"
);
echo $wsdl->saveXml();
?>