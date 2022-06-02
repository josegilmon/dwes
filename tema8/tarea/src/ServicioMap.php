<?php

namespace App;

class ServicioMap {

    public function getCoordenadas($dir) {

        $dirUrl = str_replace(" ", "%20", $dir);

        //$mapApiUrl = "http://dev.virtualearth.net/REST/v1/Locations/" . $_ENV['PAIS'] . "/" . $_ENV['CIUDAD'] . "/" . $_ENV['LOCALIDAD'] . "/" . $dirUrl . "?include=ciso2&maxResults=1&c=es&strictMatch=1&key=" . $_ENV['MAP_API_KEY'];
        $mapApiUrl = "http://dev.virtualearth.net/REST/v1/Locations?countryRegion=".$_ENV['PAIS']."&adminDistrict=".$_ENV['CIUDAD']."&locality=".$_ENV['LOCALIDAD']."&postalCode=".$_ENV['COD_POSTAL']."&addressLine=".$dirUrl."&maxResults=1&key=".$_ENV['MAP_API_KEY'];

        $datos = $this->callMapsApi($mapApiUrl);

        $coordenadas['lat'] = $datos["resourceSets"][0]["resources"][0]["point"]["coordinates"][0];
        $coordenadas['lon'] = $datos["resourceSets"][0]["resources"][0]["point"]["coordinates"][1];
        return $coordenadas;
    }

    public function getAltitud($lat, $lon) {
        $mapApiUrl = "http://dev.virtualearth.net/REST/v1/Elevation/List?points=".$lat.",".$lon."&key=".$_ENV['MAP_API_KEY'];

        $datos = $this->callMapsApi($mapApiUrl);

        return $datos["resourceSets"][0]["resources"][0]["elevations"][0];
    }

    public function getRutaOptimizada($repartos) {

        $waypoints = "";
        for ($i = 0; $i < sizeof($repartos); $i++) {
            $reparto = $repartos[$i];
            $waypoints .= "&wp.".$i."=".$reparto->getLat().",".$reparto->getLon();
        }
        // Add starting point as end of the route
        $waypoints .= "&wp.".$i."=".$repartos[0]->getLat().",".$repartos[0]->getLon();

        $mapApiUrl = "http://dev.virtualearth.net/REST/V1/Routes/Driving?c=es&o=json".$waypoints."&ra=routePath&optimize=distance&key=".$_ENV['MAP_API_KEY'];

        $datos = $this->callMapsApi($mapApiUrl);

        return $datos["resourceSets"][0]["resources"][0];
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

        $datos = $this->callMapsApi($mapApiUrl);

        $ruta = $datos["resourceSets"][0]["resources"][0]['waypointsOrder'];
        array_shift($ruta);
        array_pop($ruta);
        for ($i = 0; $i < count($ruta); $i++) {
            $resp[] = substr(strstr($ruta[$i], '.'), 1);
        }
        return $resp;
    }

    private function callMapsApi($mapApiUrl) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $mapApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        return json_decode($respuesta, true);
    }

}

?>