<?php
/**
 * Desarrollo Web en Entorno Servidor
 * Tema 8 : Aplicaciones web híbridas
 * Tarea: ajaxmaps.php
 */

// Incluimos la lilbrería Xajax
require_once("../../libs/xajax_core/xajax.inc.php");

// Creamos el objeto xajax
$xajax = new xajax();

// Y registramos la función que vamos a llamar desde JavaScript
$xajax->register(XAJAX_FUNCTION,"obtenerCoordenadas");
$xajax->register(XAJAX_FUNCTION,"ordenarReparto");

// El método processRequest procesa las peticiones que llegan a la página
// Debe ser llamado antes del código HTML
$xajax->processRequest();

function ordenarReparto($coordenadasPuntosIntermedios)
{
    // Indicamos las coordenadas del almacén de donde sale la mercancía
    // Se podría añadir código para permitir al usuario indicarlas
    //  o incluso coger por defecto la ubicación actual del usuario
    $coordenadasOrigen = "42.402497,-8.812001";

    // Se comienza y finaliza la ruta de reparto en el almacén
    $url = 'http://maps.google.es/maps/api/directions/json?origin='.$coordenadasOrigen;
    // Para obtener el resultado en XML en lugar de JSON, podríamos hacer:
    // $url = 'http://maps.google.es/maps/api/directions/xml?origin='.$coordenadasOrigen;
    $url .= '&destination='.$coordenadasOrigen;
    
    // Y se añaden los puntos de envío, indicando que optimice el recorrido
    $url .= '&waypoints=optimize:true|';
    $url .= $coordenadasPuntosIntermedios;
    $url .= '&sensor=false';
    
    // Como el resultado es JSON, lo procesamos de la siguiente forma
    $json = file_get_contents($url);
    $respuesta = json_decode($json);
    $orden = $respuesta->routes[0]->waypoint_order;
    
    // Si obtuviéramos un resultado en XML, habría que procesarlo de la siguiente forma
    /*
    $xml = simplexml_load_file($url);
    // Guardamos el recorrido óptimo calculado en un array
    foreach($xml->route[0]->waypoint_index as $parada) {
        $orden[] = (integer) $parada;
    }
     */
    
    // Y devolvemos el array obtenido
    $respuesta = new xajaxResponse();
    $respuesta->setReturnValue($orden);
    return $respuesta;
}

function obtenerCoordenadas($parametros)
{
    $respuesta = new xajaxResponse();
    $search = 'http://maps.google.com/maps/api/geocode/xml?address='.$parametros['direccion'].'&sensor=false&appid=z9hiLa3e';
    $xml = simplexml_load_file($search);

    $respuesta->assign("latitud", "value", (string) $xml->result[0]->geometry->location->lat);
    $respuesta->assign("longitud", "value", (string) $xml->result[0]->geometry->location->lng);

    $search = 'http://maps.google.com/maps/api/elevation/json?locations=';
    $search.= (string) $xml->result[0]->geometry->location->lat . ',' . (string) $xml->result[0]->geometry->location->lng;
    $search.= '&sensor=false';
    $json = file_get_contents($search);
    $altitud = json_decode($json);
    
    $respuesta->assign("altitud", "value", $altitud->results[0]->elevation);
    
    $respuesta->assign("obtenerCoordenadas","value","Obtener coordenadas");
    $respuesta->assign("obtenerCoordenadas","disabled",false); 
    
    return $respuesta;
}

?>
