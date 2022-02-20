<?php

/*     require_once('./CurrencyConvertor.php');

    $cliente = new CurrencyConvertor();
    print_r($cliente->__getTypes());
    print_r($cliente->__getFunctions());
 */

$cliente = new SoapClient(
    "http://localhost/dwes/wsdl/CurrencyConvertor.WSDL",
    array('trace'=>true)
);
?>