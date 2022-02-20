<?php
session_start();

require_once("constantes.php");

// Esta función determina si la opción que se pasa por parámetro, tiene guardado en sesión el valor que se indica
function isSelected($opcion, $valor) {
    if (isset($_SESSION[$opcion]) && $_SESSION[$opcion] == $valor) {
        echo "selected";
    }
    return;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Fontawesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <title>Preferencias</title>
</head>

<body style="background:silver;">
    <?php
    ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Preferencias Usuario</h3>
                </div>
                <div class="card-body">
                    <?php
                        // Si se ha enviado el formulario con las preferencias, las guardamos y mostramos el mensaje que lo indica
                        if (isset($_POST["establecer"])) {
                            foreach($preferencias as $k => $v) {
                                if (isset($_POST[$k])) {
                                    $_SESSION[$k] = $_POST[$k];
                                }
                            }
                            echo "<p class='card-text text-primary'>Preferencias de usuario guardadas.</p>";
                        }
                    ?>
                    <form name='login' method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                        <label for="inputGroupSelect01" class="form-label">Idioma</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">
                                <i class="fas fa-language"></i>
                            </label>
                            <select class="form-select" id="inputGroupSelect" name="idioma" required>
                                <option <?php isSelected($idioma, "Español") ?>>Español</option>
                                <option <?php isSelected($idioma, "Inglés") ?>>Inglés</option>
                            </select>
                        </div>
                        <label for="inputGroupSelect02" class="form-label">Perfil público</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fas fa-users"></i></label>
                            <select class="form-select" id="inputGroupSelect02" name="perfil" required>
                                <option <?php isSelected($perfil, "Sí") ?>>Sí</option>
                                <option <?php isSelected($perfil, "No") ?>>No</option>
                            </select>
                        </div>
                        <label for="inputGroupSelect03" class="form-label">Zona Horaria</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect03"><i class="far fa-clock"></i></label>
                            <select class="form-select" id="inputGroupSelect03" name="zona" required>
                                <option <?php isSelected($zona, "GMT-2") ?>>GMT-2</option>
                                <option <?php isSelected($zona, "GMT-1") ?>>GMT-1</option>
                                <option <?php isSelected($zona, "GMT") ?>>GMT</option>
                                <option <?php isSelected($zona, "GMT+1") ?>>GMT+1</option>
                                <option <?php isSelected($zona, "GMT+2") ?>>GMT+2</option>
                            </select>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col pl-0">
                                    <a href="mostrar.php" class="btn btn-primary">Mostrar preferencias</a>
                                </div>
                                <div class="col pr-0">
                                    <input type="submit" value="Establecer preferencias" class="btn floatright btn-success" name='establecer'>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>