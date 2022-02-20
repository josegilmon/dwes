<?php
/**
 * Desarrollo Web en Entorno Servidor
 * Tema 8 : Aplicaciones web híbridas
 * Ejemplo geocodificación: form.php
 */

// Incluimos la lilbrería Xajax
require_once("./include/xajax_core/xajax.inc.php");

// Creamos las funciones que van a ser llamadas
//  desde JavaScript

function ubicaryahoo($coordenadas){
    $respuesta = new xajaxResponse();
    // Hacemos una búsqueda inversa (gflags=R), esto es
    //  obtenemos una dirección a partir de unas coordenadas
    // Indicamos también búsqueda global (flags=G)
    //  y localización española para el lenguaje (locale=es_ES)
    $search = 'http://where.yahooapis.com/geocode?location='.$coordenadas['latitud'].'+'.$coordenadas['longitud'].'&flags=G&locale=es_ES&gflags=R&appid=tuID';
    $xml = simplexml_load_file($search);
    
    $respuesta->assign("calle", "value", (string) $xml->Result[0]->street . " " . $xml->Result[0]->house);
    $respuesta->assign("ciudad", "value", (string) $xml->Result[0]->level3 . " " . $xml->Result[0]->level2 . " " . $xml->Result[0]->level1);
    $respuesta->assign("pais", "value", (string) $xml->Result[0]->level0);
    $respuesta->assign("cp", "value", (string) $xml->Result[0]->uzip);
    
    $respuesta->assign("enviarcoordenadas","value","Ver dirección");
    $respuesta->assign("enviarcoordenadas","disabled",false);
    $respuesta->assign("enviardireccion","disabled",false);
    return $respuesta;
}

function ubicargoogle($coordenadas){
    $respuesta = new xajaxResponse();
    // Indicamos idioma español (language=es) y
    //  que no estamos usando un sensor de localización (sensor=false)
    // $search = 'http://maps.google.com/maps/api/geocode/xml?address='.$coordenadas['calle'].'+'.$coordenadas['ciudad'].'+'.$coordenadas['pais'].'&language=es&sensor=false';
    $search = 'http://maps.google.com/maps/api/geocode/json?latlng='.$coordenadas['latitud'].','.$coordenadas['longitud'].'&language=es&sensor=false';

    $xml = simplexml_load_file($search);
    
    $respuesta->assign("latitud", "value", (string) $xml->result[0]->geometry->location->lat);
    $respuesta->assign("longitud", "value", (string) $xml->result[0]->geometry->location->lng);
    
    $respuesta->assign("enviardireccion","value","Ver coordenadas");
    $respuesta->assign("enviarcoordenadas","disabled",false);
    $respuesta->assign("enviardireccion","disabled",false);
    return $respuesta;
}
// Creamos el objeto xajax
$xajax = new xajax();

// Registramos las funciones que vamos a llamar desde JavaScript
$xajax->register(XAJAX_FUNCTION,"ubicaryahoo");
$xajax->register(XAJAX_FUNCTION,"ubicargoogle");

// Y configuramos la ruta en que se encuentra la carpeta xajax_js
$xajax->configure('javascript URI','./include/');

// El método processRequest procesa las peticiones que llegan a la página
// Debe ser llamado antes del código HTML
$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Ejemplo Tema 8: Geolocation con jQuery4PHP</title>
  <link rel="stylesheet" href="estilos.css" type="text/css" />
  <?php
  // Le indicamos a Xajax que incluya el código JavaScript necesario
  $xajax->printJavascript(); 
  ?>
  <script type="text/javascript" src="ubicar.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        navigator.geolocation.getCurrentPosition(
            function(posicion){
                $("#latitud").val(posicion.coords.latitude);
                $("#longitud").val(posicion.coords.longitude);
            }
        )    });
    // ]]>
  </script>
</head>

<body>
    <div id='form'>
    <form id='datos' action="javascript:void(null);">
    <fieldset>
        <legend>Servicios de geocodificación</legend>
        <div class='campo'>
            <label for='latitud' >Latitud:</label>
            <input type='text' name='latitud' id='latitud' />
        </div>
        <div class='campo'>
            <label for='longitud' >Longitud:</label>
            <input type='text' name='longitud' id='longitud' />
        </div>
        
        <div class='campo'>
            <input type='submit' id='enviarcoordenadas' name='enviar' value='Ver dirección con Yahoo!' onclick="enviarCoordenadas();"/>
            <input type='submit' id='enviardireccion' name='enviar' value='Ver coordenadas con Google' onclick="enviarDireccion();"/>
        </div>
        <div class='campo'>
            <label for='calle' >Calle:</label>
            <input type='text' name='calle' id='calle' />
        </div>
        <div class='campo'>
            <label for='ciudad' >Ciudad:</label><br />
            <input type='text' name='ciudad' id='ciudad' />
        </div>
        <div class='campo'>
            <label for='pais' >País:</label><br />
            <input type='text' name='pais' id='pais' />
        </div>
        <div class='campo'>
            <label for='cp' >CP:</label><br />
            <input type='text' name='cp' id='cp' maxlength="5" />
        </div>
    </fieldset>
    </form>
    </div>
</body>
</html>
