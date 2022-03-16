<?php

require '../vendor/autoload.php'; 

use Wsdl2PhpGenerator\Generator;
use Wsdl2PhpGenerator\Config;

$generator = new Generator();
$generator->generate(
    new Config([
        'inputFile' => "http://dwes/tema6/tarea/servidorSoap/servicio.wsdl",
        'outputDir' => './Clases1',  //directorio donde vamos a generar las clases
        'namespaceName' => 'Clases'  //namespace que vamos a usar con ellas (lo indicamos en composer)
    ])
);

?>