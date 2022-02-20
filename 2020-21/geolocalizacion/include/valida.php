<?php
/**
 * Desarrollo Web en Entorno Servidor
 * Tema 7 : Aplicaciones web dinámicas: PHP y Javascript
 * Ejercicio: Formulario de Login con Xajax: verifica.php
 */

// Incluimos la lilbrería Xajax
require_once('xajax_core/xajax.inc.php');
require_once('DB.php');

// Creamos el objeto xajax
$xajax = new xajax();

// Registramos la función que vamos a llamar desde JavaScript
$xajax->register(XAJAX_FUNCTION,"validarLogin");

// El método processRequest procesa las peticiones que llegan a la página
// Debe ser llamado antes del código HTML
$xajax->processRequest();

// Validamos el nombre y contraseña enviados
function validarLogin($usuario, $password) {
    $respuesta = new xajaxResponse();

    if (empty($usuario) || empty($password)) 
        // $error = "Debes introducir un nombre de usuario y una contraseña";
        $respuesta->setReturnValue(false);
    else {
        // Comprobamos las credenciales con la base de datos
        if (DB::verificaCliente($usuario, $password)) {
            session_start();
            $_SESSION['usuario']=$usuario;
            $respuesta->setReturnValue(true);
        }
        else {
            // Si las credenciales no son válidas
            $respuesta->setReturnValue(false);
        }
    }

    return $respuesta;
}

?>