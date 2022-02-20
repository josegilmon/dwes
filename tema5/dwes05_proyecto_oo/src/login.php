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


if (isset($_REQUEST['logout'])) {
    unset($_SESSION['usuario']);
} else if (isset($_SESSION['usuario'])) {
    header('Location:listado.php');
} else if (isset($_POST['login'])) {
    $nombreUsuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $pass = trim(filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING));
    $errorLoginForm = strlen($nombreUsuario) === 0 || strlen($pass) === 0;
    /* if (strlen($nombre) == 0 || strlen($pass) == 0) {
      error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
      } */
    if (!$errorLoginForm) {
        $usuario = Usuario::recuperaUsuarioPorCredencial($bd, $nombreUsuario, $pass);
        $errorCredenciales = is_null($usuario);
        if (!$errorCredenciales) {
            $_SESSION['usuario'] = $nombreUsuario;
            header('Location:listado.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!--Fontawesome CDN-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
              integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <title>Login</title>
    </head>
    <body style="background:silver;" class="d-flex justify-content-center h-100">
        <main class="l-mainContent col-3">
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form name='login' method='POST' action='<?= $_SERVER['PHP_SELF'] ?>'>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($nombreUsuario))) ? "is-invalid" : "") ?>" placeholder="usuario" name='usuario' >
                                <div class="invalid-feedback">
                                    <p>Introduce el usuario</p>
                                </div>
                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" class="<?= "form-control " . ((isset($errorLoginForm) && (empty($pass))) ? "is-invalid" : "") ?>" placeholder="contraseña" name='pass' >
                                <div class="invalid-feedback">
                                    <p>Introduce el password</p>
                                </div>
                            </div>
                            <?php if (isset($errorCredenciales) && $errorCredenciales): ?>
                                <div class="alert alert-danger" role="alert">
                                    Credenciales incorrectos
                                </div>
                            <?php endif ?>
                            <div class="form-group">
                                <a href='listado.php' class='btn btn-info'>Acceso como Invitado</a>
                                <input type="submit" value="Login" class="btn float-right btn-success" name='login'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>