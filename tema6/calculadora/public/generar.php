<?php

// utilizamos el autoload de composer
require '../vendor/autoload.php'; 

use Wsdl2PhpGenerator\Generator;
use Wsdl2PhpGenerator\Config;

$generator = new Generator();
$generator->generate(
    new Config([
        'inputFile' => "http://www.dneonline.com/calculator.asmx?WSDL", //wsdl
        'outputDir' => '../src',  // directorio donde vamos a generar las clases
        'namespaceName' => 'App'  // namespace que vamos a usar con ellas (lo indicamos en composer)
    ])
);

?>