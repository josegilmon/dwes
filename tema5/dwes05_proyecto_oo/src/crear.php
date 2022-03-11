<?php
session_start();
//Hacemos el autoload de las clases
spl_autoload_register(function ($class) {
    require "../model/" . $class . ".php";
});
if (!(isset($_REQUEST['pet-crear']) || isset($_REQUEST['crear']))) {
    header('Location:listado.php');
}

$usuario = ($_SESSION['usuario']) ?? false;

try {
        $bd = BD::getConexion();
    } catch (PDOException $error) {
         die("Error en la conexión con la BD");
    }

if (isset($_REQUEST['crear'])) {
    
//recogemos los datos del formlario, trimamos las cadenas
    $nombre = ucwords(trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)));
    $nombreCorto = strtoupper(trim(filter_input(INPUT_POST, 'nombre_corto', FILTER_SANITIZE_STRING)));
    $pvp = filter_input(INPUT_POST, 'pvp', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));
    $familia = filter_input(INPUT_POST, 'familia', FILTER_SANITIZE_STRING);
    $error = strlen($pvp) === 0 || strlen($nombreCorto) === 0 || strlen($nombre) === 0;
    if (!$error) {
        $producto = new Producto($nombre, $nombreCorto, $descripcion, $pvp, $familia);
        try {
            $productoInsertado = $producto->persiste($bd);
        } catch (PDOException $ex) {
            if ($ex->getcode() == 23000) {
                $errorDuplicadoNombreCorto = true;
            } else {
                die("Ocurrio un error al insertar el producto, mensaje de error: " . $ex->getMessage());
            }
        }
    }
}
if (!(isset($productoInsertado))) {

    try {
        $familias = Familia::recuperaFamilias($bd);
    } catch (PDOException $ex) {
        die("Error al recuperar los productos " . $ex->getMessage());
    }
}
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
        <title>Crear</title>
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
        <h3 class="text-center mt-2 font-weight-bold">Crear Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoInsertado) && $productoInsertado): ?>
                <p class='text-info font-weight-bold'>Producto creado con éxito</p>
                <a href="listado.php" class="btn btn-info">Volver</a>
            <?php else: ?>
                <form name="crear" method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="<?= "form-control " . ((isset($error) && (empty($nombre))) ? "is-invalid" : "") ?>" id="nombre" placeholder="Nombre"
                                   name="nombre" value="<?= ($nombre ?? '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce nombre</p>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre_corto">Nombre Corto</label>
                            <input type="text" class="<?= "form-control " . ($errorDuplicadoNombreCorto || (isset($error) && (empty($nombreCorto))) ? "is-invalid" : "") ?>" id="nombre_corto" placeholder="Nombre Corto"
                                   name="nombre_corto" value="<?= ($nombreCorto ?? '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p><?= (isset($errorDuplicadoNombreCorto) && $errorDuplicadoNombreCorto) ? "Nombre corto duplicado" : "Introduce nombre corto" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pvp">Precio (€)</label>
                            <input type="number" class="<?= "form-control " . ((isset($error) && (empty($pvp))) ? "is-invalid" : "") ?>" id="pvp" placeholder="Precio (€)"
                                   name="pvp" min="0" step="0.01" value="<?= ($pvp ?? '') ?>">
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce PVP</p>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="familia">Familia</label>
                            <select id="familia" class="form-control" name="familia">
                                <?php foreach ($familias as $familia): ?>
                                    <option value='<?= $familia->getCod() ?>'><?= $familia->getNombre() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="d" rows="12"> <?= ($descripcion ?? '') ?></textarea>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mr-3" name="crear" value="Crear">
                    <input type="reset" value="Limpiar" class="btn btn-success mr-3" onclick="this.querySelectorAll('input[type=text]').forEach(function (input, i) {
                                input.value = '';
                            })">
                    <a href="listado.php" class="btn btn-info">Volver</a>
                </form>
            <?php endif ?>
        </div>
    </body>
</html>


