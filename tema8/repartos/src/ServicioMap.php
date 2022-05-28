<?php

namespace App;

class ServicioMap {

    public function getCoordenadas($dir) {
        $dirUrl = str_replace(" ", "%20", $dir);

        $mapApiUrl = "http://dev.virtualearth.net/REST/v1/Locations/" . $_ENV['PAIS'] . "/" . $_ENV['CIUDAD'] . "/" . $_ENV['LOCALIDAD'] . "/" . $dirUrl . "?include=ciso2&maxResults=1&c=es&strictMatch=1&key=" . $_ENV['MAP_API_KEY'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $mapApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $datos = json_decode($respuesta, true);
        $coordenadas['lat'] = $datos["resourceSets"][0]["resources"][0]["point"]["coordinates"][0];
        $coordenadas['lon'] = $datos["resourceSets"][0]["resources"][0]["point"]["coordinates"][1];
        return $coordenadas;
    }

    public function ordenarRuta($dato) {
        $base = "http://dev.virtualearth.net/REST/v1/Routes/Driving?c=es&waypoint.0=" . $_ENV['LAT_BASE'] . "," . $_ENV['LON_BASE'] . "&";
        $puntos = explode("|", $dato);
        $num = 1;
        $trozo = "";
        for ($i = 0; $i < count($puntos); $i++) {
            $trozo .= "waypoint." . $num++ . "=" . $puntos[$i] . "&";
        }
        $trozo .= "waypoint." . $num . "=" . $_ENV['LAT_BASE'] . "," . $_ENV['LON_BASE'] . "&optimize=distance&optWp=true&routeAttributes=routePath&key=" . $_ENV['MAP_API_KEY'];
        $mapApiUrl = $base . $trozo;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $mapApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $respuesta = curl_exec($ch);
        curl_close($ch);
        $datos = json_decode($respuesta, true);
        $ruta = $datos["resourceSets"][0]["resources"][0]['waypointsOrder'];
        array_shift($ruta);
        array_pop($ruta);
        for ($i = 0; $i < count($ruta); $i++) {
            $resp[] = substr(strstr($ruta[$i], '.'), 1);
        }
        return $resp;
    }

}

?>