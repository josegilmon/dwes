<?php
if (!isset($_POST['pet-borrar'])) {
//si no me llega el código del producto a borrar
//nos vamos a listado.php
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
     die("Error en la conexión con la BD");
}
$id = $_POST['id'];

try {
    $producto = Producto::recuperaProductoPorId($bd, $id);
    $productoBorrado = $producto->elimina($bd);
} catch (PDOException $ex) {
    die("Error al borrar el producto" . $ex->getMessage());
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
            <input type="text" size='10px' value="<?= $usuario ?>" class="form-control mr-2 bg-transparent text-white" disabled>
            <?php if ($usuario): ?>
                <a href='cerrar.php' class='btn btn-danger mr-2'>Salir</a>
            <?php else: ?>
                <a href='login.php' class='btn btn-primary mr-2'>Login</a>
            <?php endif ?>
        </div>
        <h3 class="text-center mt-2 font-weight-bold">Borrar Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoBorrado) && $productoBorrado): ?>
                <p class='text-info font-weight-bold'>Producto borrado con éxito</p>
                <a href="listado.php" class="btn btn-info">Volver</a>
            <?php endif ?>
        </form>
    </div>
</body>
</html>
