<?php

require "../vendor/autoload.php";


use Tarea\Operaciones;

$operaciones = new Operaciones();

// creamos un array con varios productos de ejemplo para buscar sus precios 
$productos = [
    "1" => "Nintendo 3DS negro",
    "2" => "Acer AX3950 I5-650 4GB 1TB W7HP",
    "3" => "Archos Clipper MP3 2GB negro",
    "4" => "Sony Bravia 32IN FULLHD KDL-32BX400",
    "5" => "Asus EEEPC 1005PXD N455 1 250 BL"
];

// creamos un array con las tiendas para buscar su stock
$tiendas = ["1" => "CENTRAL", "2" => "SUCURSAL1", "3" => "SUCURSAL2"];


// recuperamos las familias para mostrarlas y crear el "select" para buscar sus productos
$familias = $operaciones->getFamilias();


if (isset($_POST["producto"])) {
    $producto = $_POST["producto"];
    if (isset($_POST["btnPvp"])) {
        $pvp = $operaciones->getPVP($producto);
    }
    if (isset($_POST["btnStock"]) && isset($_POST["tienda"])) {
        $stock = $operaciones->getStock($producto, $_POST["tienda"]);
    }
}

if (isset($_POST["btnProductos"]) && isset($_POST["familia"])) {
    $productosFamilia = $operaciones->getProductosFamilia($_POST["familia"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>

    <!-- css para usar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        crossorigin="anonymous">

</head>

<body>
<form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
    <div class="container-fluid w-50 bg-success text-white p-4">

        <h3 class="text-center">Cliente SOAP</h3>

        <div>
            <label for="producto">Selecciona un producto:</label>
            <select name="producto" id="producto" class="form-select">
                <?php
                    foreach($productos as $clave => $valor) {
                        echo "<option value='$clave'>$valor</option>";
                    }
                ?>
            </select>
            <button type="submit" name="btnPvp" class="btn btn-primary">Ver precio</button>
            <?php
                if (isset($pvp)) {
                    echo "PVP: $pvp";
                }
            ?>
        </div>
        <br>
        <div>
            <label for="tienda">Selecciona una tienda:</label>
            <select name="tienda" id="tienda" class="form-select">
                <?php
                    foreach($tiendas as $clave => $valor) {
                        echo "<option value='$clave'>$valor</option>";
                    }
                ?>
            </select>
            <button type="submit" name="btnStock" class="btn btn-primary">Ver stock</button>
            <?php
                if (isset($stock)) {
                    echo "Stock: $stock";
                }
            ?>
        </div>
        <br>
        <div>
            Familias de productos:
            <ul>
                <?php
                    foreach($familias as $familia) {
                        echo "<li>" . $familia->getNombre() . "</li>";
                    }
                ?>
            </ul>

        </div>
        <br>
        <div>
            <label for="familia">Selecciona una familia:</label>
            <select name="familia" id="familia" class="form-select">
                <?php
                    foreach($familias as $familia) {
                        echo "<option value='". $familia->getCod() ."'>". $familia->getNombre() ."</option>";
                    }
                ?>
            </select>
            <button type="submit" name="btnProductos" class="btn btn-primary">Ver productos</button>
            <ul>
                <?php
                    if (isset($productosFamilia)) {
                        foreach($productosFamilia as $producto) {
                            echo "<li>" . $producto->getNombre() . "</li>";
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</form>
</body>
</html>