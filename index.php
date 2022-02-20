<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "
    http://www.w3.org/TR/html4/loose.dtd">
<!-- Desarrollo Web en Entorno Servidor -->
<!-- Tema 4 : Desarrollo de aplicaciones web con PHP -->
<!-- Ejemplo: Utilización de MySQL para autentificación HTTP -->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Ejemplo Tema 4: Utilización de MySQL para autentificación HTTP</title>
        <link href="dwes.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
        echo "Nombre de usuario: " . $_SERVER['PHP_AUTH_USER'] . "<br />";
        echo "Hash de la contraseña: " . md5($_SERVER['PHP_AUTH_PW']) . "<br />";
        
        phpinfo();
        ?>
    </body>
</html>