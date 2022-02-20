<?php
session_start();
//Hacemos el autoload de las clases
spl_autoload_register(function ($class) {
    require "../model/" . $class . ".php";
});

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
     die("Error en la conexión con la BD");
}

try {
    $productos = Producto::recuperaProductos($bd);
} catch (PDOException $ex) {
    die("Error al recuperar los productos " . $ex->getMessage());
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Tema 3</title>
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
        <h3 class="text-center mt-2 font-weight-bold">Gestión de Productos</h3>
        <div class="container mt-3">
            <a href="crear.php?pet-crear" class="btn btn-success mt-2 mb-2 <?= ($usuario) ? '' : 'disabled' ?>" >Crear</a>
            <table class="table table-striped table-dark">
                <thead>
                    <tr class="text-center">
                        <th scope="col">Detalle</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr class='text-center'>
                            <th scope='row'>
                                <form action='detalle.php' method='POST' style='display:inline'>
                                    <input type='hidden' name='id' value='<?= $producto->getId() ?>'>
                                    <input type='submit' class='btn btn-warning mr2' value="Detalle" name="pet-detalle">
                                </form>
                            <td><?= $producto->getId() ?></td>
                            <td><?= $producto->getNombre() ?></td>
                            <td>
                                <form action='modificar.php' method='POST' style='display:inline'>
                                    <input type='hidden' name='id' value='<?= $producto->getId() ?>'>
                                    <input type='submit' class='btn btn-warning <?= ($usuario) ? '' : 'disabled' ?>' value="Actualizar" name="pet-modificar">
                                </form>
                                <form action='borrar.php' method='POST' style='display:inline'>
                                    <input type='hidden' name='id' value='<?= $producto->getId() ?>'> <!-- mandamos el código del producto a borrar -->
                                    <input type='submit' onclick="return confirm('¿Borrar Producto?')" class='btn btn-danger <?= ($usuario) ? '' : 'disabled' ?>' value="Borrar" name="pet-borrar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

