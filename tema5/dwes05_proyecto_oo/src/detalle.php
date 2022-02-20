<?php
if (!isset($_REQUEST['pet-detalle'])) { //si no mandamos el id volvemos a listado
    header('Location:listado.php');
}
session_start();
//Hacemos el autoload de las clases
spl_autoload_register(function ($class) {
    require "../model/" . $class . ".php";
});

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
    die;
}

$id = $_POST['id'];
try {
    $producto = Producto::recuperaProductoPorId($bd, $id);
} catch (PDOException $ex) {
    die("Error al recuperar el producto " . $ex->getMessage());
}

$usuario = ($_SESSION['usuario']) ?? false;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- css para usar Bootstrap -->
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Detalle</title>
    </head>
    <body style="background: #4dd0e1">
        <div class="float float-right d-inline-flex mt-2">
            <i class="fas fa-user mr-3 fa-2x"></i>
            <input type="text" size='10px' value="<?= $usuario ?>"
                   class="form-control mr-2 bg-transparent text-white" disabled>
                   <?php if ($usuario): ?>
                <a href='login.php?logout' class='btn btn-danger mr-2'>Salir</a>
            <?php else: ?>
                <a href='login.php' class='btn btn-primary mr-2'>Login</a>
            <?php endif ?>
        </div>
        <br><br>
        <h3 class="text-center mt-2 font-weight-bold">Detalle Producto</h3>
        <div class="container mt-3">
            <div class="card text-white bg-info mt-5 mx-auto" style="max-width: 58rem;">
                <div class="card-header text-center text-weight-bold">
                    <?= $producto->getNombre() ?>
                </div>
                <div class="card-body" style="font-size: 1.1em">
                    <h5 class="card-title text-center"><?= "Codigo: {$producto->getId()}" ?></h5>
                    <p class="card-text"><b>Nombre:</b><?= $producto->getNombre() ?></p>
                    <p class="card-text"><b>Nombre Corto: </b> <?= $producto->getNombreCorto() ?></p>
                    <p class="card-text"><b>Codigo Familia: </b><?= $producto->getFamilia() ?></p>
                    <p class="card-text"><b>PVP (€): </b><?= $producto->getPvp() ?></p>
                    <p class="card-text"><b>Descripción: </b><?= $producto->getDescripcion() ?></p>
                </div>
            </div>
            <div class="container mt-5 text-center">
                <a href="listado.php" class="btn btn-info">Volver</a>
            </div>
        </div>
    </body>
</html>

