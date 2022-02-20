<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado</title>

    <!-- css para usar Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- css Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous"></head>

<body>

    <h2>Gestión de productos</h2>
    <div class="container">
        <div class="row text-center">
            <div class="col">Detalle</div>
            <div class="col">Código</div>
            <div class="col">Nombre</div>
            <div class="col">Acciones</div>
        </div>

        <?php

            require_once("conexion.php");

            $resultado = $conProyecto->query("SELECT * FROM productos");

            while ($producto = $resultado->fetch()) {
                echo '<div class="row text-center">';
                echo '  <div class="col"><button type="button" class="btn btn-primary">Detalle</button></div>';
                echo '  <div class="col">'.$producto["id"]."</div>";
                echo '  <div class="col">'.$producto["nombre"]."</div>";
                echo '  <div class="col"><button type="button" class="btn btn-warning">Actualizar</button><button type="button" class="btn btn-danger">Borrar</button></div>';
                echo '</div>';
            }
        ?>
    </div>

</body>

</html>