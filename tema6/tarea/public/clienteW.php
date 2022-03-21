<?php

$url = "http://dwes/tema6/tarea/servidorSoap/servicio.wsdl";

try {
    $cliente = new SoapClient($url);
} catch (SoapFault $ex) {
    echo "Error: ".$ex->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClienteW</title>

    <!-- css para usar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        crossorigin="anonymous">

</head>
<body>

    <p>
        El precio de la Nintendo 3DS es:
        <?php
            $paramPVP = ['codigo' => 1];
            $pvp = $cliente->__soapCall('getPVP', $paramPVP);
            echo $pvp;
        ?>
    </p>

    <p>
        El stock de la Nintendo 3DS en la tienda CENTRAL es de:
        <?php
            $paramStock = ['codigo' => 1, 'tienda' => 1];
            $stock = $cliente->__soapCall('getStock', $paramStock);
            echo $stock;
        ?>
    </p>

    <p>
        Familias:
        <ul>
            <?php
                $familias = $cliente->__soapCall('getFamilias', []);
                foreach($familias as $familia) {
                    echo "<li>".$familia->nombre."</li>";
                }
            ?>
        </ul>
    </p>

    <p>
        Productos de tipo: Memorias Flash
        <ul>
            <?php
                $paramProductosFamilia = ['familia' => 'MEMFLA'];
                $productos = $cliente->__soapCall('getProductosFamilia', $paramProductosFamilia);
                foreach($productos as $producto) {
                    echo "<li>".$producto->nombre."</li>";
                }
            ?>
        </ul>
    </p>

</body>
</html>