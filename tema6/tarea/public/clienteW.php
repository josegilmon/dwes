<?php

$url = "http://dwes/tema6/tarea/servidorSoap/servicio.wsdl";

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $ex) {
    echo "Error: ".$ex->getMessage();
}

$paramPVP = ['codigo' => 1];
$pvp = $cliente->__soapCall('getPVP', $paramPVP);
echo "<p>El precio de la Nintendo 3DS es: $pvp</p>";

$paramStock = ['codigo' => 1, 'tienda' => 1];
$stock = $cliente->__soapCall('getStock', $paramStock);
echo "<p>El stock de la Nintendo 3DS en la tienda CENTRAL es de: $stock</p>";

$familias = $cliente->__soapCall('getFamilias', []);
echo "Familias: <ul>";
foreach($familias as $familia) {
    echo "<li>".$familia->nombre."</li>";
}
echo "</ul>";

$paramProductosFamilia = ['familia' => 'MEMFLA'];
$productos = $cliente->__soapCall('getProductosFamilia', $paramProductosFamilia);
echo "Productos de tipo: Memorias Flash <ul>";
foreach($productos as $producto) {
    echo "<li>".$producto->nombre."</li>";
}
echo "</ul>";

?>