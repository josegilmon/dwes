<?php
session_start();

require_once("constantes.php");

// Esta función recorre cada una de las preferencias y, si está guardada en sesión, pinta su valor en la pantalla
function pintarPreferencias() {

    global $preferencias;

    foreach($preferencias as $opcion => $valor) {
        if (!isset($_SESSION[$opcion])) {
            $valor = "No establecido";
        } else {
            $valor = $_SESSION[$opcion];
        }
        echo "<li><strong>$preferencias[$opcion]</strong>: $valor</li>";
    }
}
?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!--Fontawesome CDN -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
            integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Mostrar preferencias</title>
    </head>
    <body style="background: gray">
        <br>
        <div class="container mt-3">
            <div class="card text-white bg-success mb-3 m-auto" style="width:40rem">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-user-cog mr-2"> Preferencias</i></h5>
                    <?php
                        // Si se ha pulsado en el botón de borrar, se eliminan las sesiones. Si alguna no estuviera guardada, se muestra un mensaje de error.
                        if (isset($_POST['borrar'])) {
                            if (!isset($_SESSION[$idioma]) || !isset($_SESSION[$perfil]) || !isset($_SESSION[$zona])) {
                                echo "<p class='card-text text-danger'>Debes fijar primero las preferencias.</p>";
                            } else {
                                echo "<p class='card-text text-danger'>Preferencias Borradas.</p>";
                                unset($_SESSION[$idioma]);
                                unset($_SESSION[$perfil]);
                                unset($_SESSION[$zona]);
                            }
                        }
                        echo "<p class='card-text'>";
                        echo "<ul class='list-unstyled'>";

                        pintarPreferencias();

                        echo "</ul></p>";
                    ?>
                    <div class="row">
                        <div class="col-3 pl-0">
                            <a href="preferencias.php" class="btn btn-primary">Establecer</a>
                        </div>
                        <div class="col-9 pl-0">
                            <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post">
                                <input type="submit" value="Borrar" class="btn btn-danger ml-2" name='borrar'>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>