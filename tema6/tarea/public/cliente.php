<?php

require "../vendor/autoload.php";


use Tarea\Operaciones;

$operaciones = new Operaciones();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <p>PVP producto (Nintendo 3DS): <?php echo $operaciones->getPVP(1); ?></p>

    <p>Stock de producto/tienda: <?php echo $operaciones->getStock(1, 1); ?></p>

    <p>
        Familias de productos:
        <ul>
            <?php
                $familias = $operaciones->getFamilias();
                foreach($familias as $familia) {
                    echo "<li>" . $familia->getNombre() . "</li>";
                }
            ?>
        </ul>

    </p>

    <p>
        Productos por familia:
        <ul>
            <?php
                $productos = $operaciones->getProductosFamilia('MEMFLA');
                foreach($productos as $producto) {
                    echo "<li>" . $producto->getNombreCorto() . "</li>";
                }
            ?>
        </ul>
    </p>

</body>
</html>