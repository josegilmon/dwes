<?php
if (!(isset($_POST['pet-modificar']) || isset($_POST['modificar']))) {
    header('Location:listado.php');
}

session_start();
//Hacemos el autoload de las clases
spl_autoload_register(function ($class) {
    require "../model/" . $class . ".php";
});

$usuario = ($_SESSION['usuario']) ?? false;

try {
    $bd = BD::getConexion();
} catch (PDOException $error) {
     die("Error en la conexión con la BD");
}


if (isset($_POST['modificar'])) {
//recogemos los datos del formlario, trimamos las cadenas
    $nombre = ucwords(trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING)));
    $nombreCorto = strtoupper(trim(filter_input(INPUT_POST, 'nombre_corto', FILTER_SANITIZE_STRING)));
    $pvp = filter_input(INPUT_POST, 'pvp', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING));
    $familia = filter_input(INPUT_POST, 'familia', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id');
    $error = empty($pvp) || empty($nombreCorto) || empty($nombre);
    if (!$error) {
        $producto = new Producto($nombre, $nombreCorto, $descripcion, $pvp, $familia);
        $producto->setId($id);
        try {
            $productoModificado = $producto->persiste($bd);
        } catch (PDOException $ex) {
            if ($ex->getcode() == 23000) {
                $errorDuplicadoNombreCorto = true;
            } else {
                die("Ocurrio un error al insertar el producto, mensaje de error: " . $ex->getMessage());
            }
        }
    }
}

if (!(isset($productoModificado))) {
    $id = $_POST['id'];
    try {
        $producto = Producto::recuperaProductoPorId($bd, $id);
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
        <link rel="stylesheet"
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>Update</title>
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
        <h3 class="text-center mt-2 font-weight-bold">Modificar Producto</h3>
        <div class="container mt-3">
            <?php if (isset($productoModificado) && $productoModificado): ?>
                <p class='text-info font-weight-bold'>Producto modificado con éxito</p>
                <a href="listado.php" class="btn btn-info">Volver</a>
            <?php else: ?>
                <form method="POST" action="<?= "{$_SERVER['PHP_SELF']}" ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input type="hidden" name="id" value="<?= $id ?>" >
                            <label for="nombre">Nombre</label>
                            <input type="text" class="<?= "form-control " . ((isset($error) && (empty($nombre))) ? "is-invalid" : "") ?>" 
                                   id="nombre" placeholder="Nombre" name="nombre" value="<?= (isset($producto)) ? $producto->getNombre() : $nombre ?>" >
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce nombre</p>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre_corto">Nombre Corto</label>
                            <input type="text" class="<?= "form-control " . ($errorDuplicadoNombreCorto || (isset($error) && (empty($nombreCorto))) ? "is-invalid" : "") ?>"
                                   id="nombre_corto" value = "<?= (isset($producto)) ? $producto->getNombreCorto() : $nombre_corto ?>" name="nombre_corto" >
                            <div class="col-sm-10 invalid-feedback">
                                <p><?= (isset($errorDuplicadoNombreCorto) && $errorDuplicadoNombreCorto) ? "Nombre corto duplicado" : "Introduce nombre corto" ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="pvp">Precio (€)</label>
                            <input type="number" class="<?= "form-control " . ((isset($error) && (empty($pvp))) ? "is-invalid" : "") ?>" 
                                   id="pvp" value='<?= $producto->getPvp() ?>' name="pvp" min="0" step="0.01" >
                            <div class="col-sm-10 invalid-feedback">
                                <p>Introduce PVP</p>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="familia">Familia</label>
                            <select class="form-control" name="familia">
                                <?php foreach ($familias as $familia): ?>                                  
                                        <option value='<?= $familia->getCod() ?>' <?= ($familia->getCod() == $producto->getFamilia()) ? "selected" : "" ?>><?= $familia->getNombre() ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-9">
                            <label for="d">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="d" rows="12">
                                <?= $producto->getDescripcion() ?>
                            </textarea>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary mr-3" name="modificar" value="Modificar">
                    <input type="submit" class="btn btn-info" formaction="listado.php" value="Volver" >
                </form>
            <?php endif ?>
        </div>
    </body>
</html>