<?php

/*
 * Controlador de la aplicación Repartos
 */

require '../vendor/autoload.php';

// Uso BladeOne como motor de vistas
use eftec\bladeone\BladeOne;
// Uso Dotenv para leer variables de entorno
// Las variables de entorno se definen en el fichero .env
use Dotenv\Dotenv;
use App\ListaReparto;
use App\Reparto;
use App\ServicioMap;

session_start();
//session_destroy();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Se configura el cliente OAuth de Google

$redirect_uri = 'http://localhost/dwes/tema8/repartos/src/';
$client = new Google_Client();
$client->setApplicationName('Google Tasks API PHP');
$client->setAuthConfig('../credentials.json');
$client->setRedirectUri($redirect_uri);
$client->setScopes(Google_Service_Tasks::TASKS); //TASKS_READONLY
$client->setPrompt('select_account consent');

// Si recibo el código de autenticación del servicio de Google
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['token'] = $token;
    $client->setAccessToken($token);
    $servicio = new Google_Service_Tasks($client);
    $listasReparto = ListaReparto::recuperaListasReparto($servicio);
    echo $blade->run("repartos", compact('listasReparto'));
    die;
} else if (!empty($_SESSION['token'])) { // Si tengo el token de acceso guardado en la sesión
    $client->setAccessToken($_SESSION['token']);
    if ($client->isAccessTokenExpired()) { // Si el token de acceso ha expirado
        unset($_SESSION['token']);
    } else { //si el token de acceso es válido
        $servicio = new Google_Service_Tasks($client); // Creo el servicio de cliente con Google Tasks API
        if (isset($_POST['nueva-lista-repartos'])) { // Si se solicita la creación de una nueva lista de repartos
            $nombreListaReparto = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
            $listaReparto = new ListaReparto($nombreListaReparto);
            $listaReparto->persiste($servicio);
            $listasReparto = ListaReparto::recuperaListasReparto($servicio);
            echo $blade->run("repartos", compact('listasReparto'));
            die;
        } if (isset($_POST['borra-lista-reparto'])) { // Si se solicita que se borre una lista de reparto
            $listaRepartoId = filter_input(INPUT_POST, 'lista-reparto-id', FILTER_SANITIZE_STRING);
            $listaReparto = new ListaReparto();
            $listaReparto->setId($listaRepartoId);
            $listaReparto->elimina($servicio);
            $listasReparto = ListaReparto::recuperaListasReparto($servicio);
            echo $blade->run("repartos", compact('listasReparto'));
            die;
        }if (isset($_POST['pet-nuevo-reparto'])) { // Si se solicita el formulario para crear un reparto
            $listaRepartoId = filter_input(INPUT_POST, 'lista-reparto-id', FILTER_SANITIZE_STRING);
            echo $blade->run("form-reparto", compact('listaRepartoId'));
            die;
        } if (isset($_POST['nuevo-reparto'])) { // Si se solicita que se usen los datos del formulario para crear un reparto
            $listaRepartoId = filter_input(INPUT_POST, 'lista-reparto-id', FILTER_SANITIZE_STRING);
            $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
            $producto = filter_input(INPUT_POST, 'producto', FILTER_SANITIZE_STRING);
            $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
            $lon = filter_input(INPUT_POST, 'lon', FILTER_SANITIZE_STRING);
            $reparto = new Reparto($direccion, $producto, $lat, $lon);
            $reparto->setListaRepartoId($listaRepartoId);
            $reparto->persiste($servicio);
            $listasReparto = ListaReparto::recuperaListasReparto($servicio);
            echo $blade->run("repartos", compact('listasReparto'));
            die;
        } if (isset($_POST['borra-reparto'])) { // Si se solicita que se borre un reparto
            $listaRepartoId = filter_input(INPUT_POST, 'lista-reparto-id', FILTER_SANITIZE_STRING);
            $repartoId = filter_input(INPUT_POST, 'reparto-id', FILTER_SANITIZE_STRING);
            $reparto = new Reparto();
            $reparto->setId($repartoId);
            $reparto->setListaRepartoId($listaRepartoId);
            $reparto->elimina($servicio);
            $listasReparto = ListaReparto::recuperaListasReparto($servicio);
            echo $blade->run("repartos", compact('listasReparto'));
            die;
        } if (isset($_POST['mapa-reparto'])) {
            $lat = filter_input(INPUT_POST, 'lat', FILTER_SANITIZE_STRING);
            $lon = filter_input(INPUT_POST, 'lon', FILTER_SANITIZE_STRING);
            echo $blade->run("mapa", compact('lat', 'lon'));
            die;
        }if (isset($_POST['ver-coordenadas'])) { // Si se solicita que se envíen las coordenadas de una dirección
            $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
            $servicioMap = new ServicioMap();
            $coordenadas = $servicioMap->getCoordenadas($direccion);
            header('Content-type: application/json');
            echo json_encode($coordenadas);
            die;
        } if (isset($_POST['ordenar-envios'])) { // Si se solicita que se ordene la ruta de los repartos
            $listaRepartoId = filter_input(INPUT_POST, 'lista-reparto-id', FILTER_SANITIZE_STRING);
            $listaReparto = ListaReparto::recuperaListaReparto($servicio, $listaRepartoId);
            $servicioMap = new ServicioMap();
            $ordenRepartos = $listaReparto->ordena($servicio, $servicioMap);
            //    $ordenRepartos = array_map(fn($x) => $x->getId(), $listaReparto->getRepartos());
            header('Content-type: application/json');
            echo json_encode(compact('listaRepartoId', 'ordenRepartos'));
            die;
        } else { // En otro caso muestra el listado de las listas de reparto
            $listasReparto = ListaReparto::recuperaListasReparto($servicio);
            echo $blade->run("repartos", compact('listasReparto'));
            die;
        }
    }
} else { // Inicia la solicitud del código de autorización
    $authUrl = $client->createAuthUrl();
    header("Location:$authUrl");
}

?>