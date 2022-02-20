<?php
/**
 * Desarrollo Web en Entorno Servidor
 * Tema 7 : Aplicaciones web dinámicas: PHP y Javascript
 * Ejemplo Validación formulario con Xajax: form.php
 */

// Incluimos la lilbrería Xajax
require_once("xajax_core/xajax.inc.php");

// Creamos las funciones de validación, que van a ser llamadas
//  desde JavaScript

function validarNombre($nombre){
    if(strlen($nombre) < 4) return false;
    return true;
}

function validarEmail($email){
    return preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email);
}

function validarPasswords($pass1, $pass2) {
    return $pass1 == $pass2 && strlen($pass1) > 5;
}

function validarFormulario($valores) {
    $respuesta = new xajaxResponse();
    $error = false;

    if (!validarNombre($valores['nombre'])) {
        $respuesta->assign("errorNombre", "innerHTML", "El nombre debe tener más de 3 caracteres.");
        $error = true;
    }
    else $respuesta->clear("errorNombre", "innerHTML");
    
    if (!validarPasswords($valores['password1'], $valores['password2'])) {
        $respuesta->assign("errorPassword", "innerHTML", "La contraseña debe ser mayor de 5 caracteres o no coinciden.");
        $error = true;
    }
    else $respuesta->clear("errorPassword", "innerHTML");

    if (!validarEmail($valores['email'])) {
        $respuesta->assign("errorEmail", "innerHTML", "La dirección de email no es válida.");
        $error = true;
    }
    else $respuesta->clear("errorEmail", "innerHTML");

    if (!$error) $respuesta->alert("Todo correcto.");

    $respuesta->assign("enviar","value","Enviar");
    $respuesta->assign("enviar","disabled",false);

    return $respuesta;    
}

// Creamos el objeto xajax
$xajax = new xajax();

// Registramos la función que vamos a llamar desde JavaScript
$xajax->register(XAJAX_FUNCTION,"validarFormulario");
// Y configuramos la ruta en que se encuentra la carpeta xajax_js
$xajax->configure('javascript URI','./');

// El método processRequest procesa las peticiones que llegan a la página
// Debe ser llamado antes del código HTML
$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ejemplo Tema 7: Validación formulario con Xajax</title>
  <link rel="stylesheet" href="estilos.css" type="text/css" />
  <?php
  // Le indicamos a Xajax que incluya el código JavaScript necesario
  $xajax->printJavascript(); 
  ?>
  <script type="text/javascript" src="validar.js"></script>
</head>

<body>
    <div id='form'>
    <!-- Cuando se vaya a enviar el formulario ejecutamos
           una función en JavaScript, que realiza la llamada a PHP -->
    <form id='datos' action="javascript:void(null);" onsubmit="enviarFormulario();">
    <fieldset >
        <legend>Introducción de datos</legend>
        <div class='campo'>
            <label for='nombre' >Nombre:</label><br />
            <input type='text' name='nombre' id='nombre' maxlength="50" /><br />
            <span id="errorNombre" class="error" for="nombre"></span>
        </div>
        <div class='campo'>
            <label for='password1' >Contraseña:</label><br />
            <input type='password' name='password1' id='password1' maxlength="50" />
            <span id="errorPassword" class="error" for="password"></span>
        </div>
        <div class='campo'>
            <label for='password2' >Repita la contraseña:</label><br />
            <input type='password' name='password2' id='password2' maxlength="50" />
        </div>
        <div class='campo'>
            <label for='email' >Email:</label><br />
            <input type='text' name='email' id='email' maxlength="50" />
            <span id="errorEmail" class="error" for="email"></span>
        </div>

        <div class='campo'>
            <input type='submit' id='enviar' name='enviar' value='Enviar' />
        </div>
    </fieldset>
    </form>
    </div>
</body>
</html>
