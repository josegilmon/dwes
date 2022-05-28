<?php

namespace App;

use App\Reparto;
use App\ServicioMapa;
use Google\Service\Tasks;
use Google\Service\Tasks\TaskList;

/**
 * ListaReparto representa una lista de repartos
 */
class ListaReparto {

    /**
     * Identificador de la lista de reparto que corresponde al identificador de la tasklist en Google Tasks
     */
    private $id = null;

    /**
     * Nombre de la lista de repartos
     */
    private $nombre;

    /**
     * Array de repartos de la lista de repartos
     */
    private $repartos;

    /**
     * Patrón para ignorar la lista de tareas por defecto en Google Tasks
     */
    const PATRON_TAREA_DEFECTO = "/Mis tareas|Lista de/";

    /**
     * Constructor de la clase ListaReparto
     * 
     * @param string $nombre Nombre de la lista de repartos
     * 
     * @returns ListaReparto
     */
    public function __construct(string $nombre = null) {
        $this->nombre = $nombre;
        $this->repartos = [];
    }

    /**
     * Recupera un objeto ListaReparto dado el identificador de la tasklist en Google Tasks
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * @param string $id Identificador de la tasklist
     * 
     * @returns Objeto ListaReparto asociado al identificador de la tasklist
     */
    public static function recuperaListaReparto(Tasks $servicio, string $id): ?ListaReparto {
        $taskList = $servicio->tasklists->get($id);
        if (!is_null($taskList)) {
            $listaReparto = new Self($taskList->getTitle());
            $listaReparto->setId($taskList->getId());
            $tasksList = $servicio->tasks->listTasks($taskList->getId());
            $repartos = [];
            foreach ($tasksList->getItems() as $task) {
                $repartos[intval($task->position)] = Reparto::recuperaReparto($servicio, $id, $task->getId());
            }
            ksort($repartos);
            $listaReparto->setRepartos($repartos);
            return ($listaReparto);
        }
    }
    
    /**
     * Recupera todos los objetos ListaReparto de las listas de tareas en Google Tasks
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * 
     * @returns Array de objetos ListaReparto asociados a las tasklists
     */

    public static function recuperaListasReparto(Tasks $servicio): ?array {
        $optParams = ['maxResults' => 100];
        $tasklists = $servicio->tasklists->listTasklists($optParams);
        $listasReparto = [];
        foreach ($tasklists->getItems() as $taskList) {
            if (!preg_match(self::PATRON_TAREA_DEFECTO, $taskList->getTitle())) {
                $listasReparto[] = self::recuperaListaReparto($servicio, $taskList->getId());
            }
        }
        return ($listasReparto);
    }
    
     /**
     * Persiste un objeto ListaReparto creando una tasklist en Google Tasks
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * 
     * @returns Booleano indicando si la acción tuvo éxito
     */

    public function persiste(Tasks $servicio): bool {
        $result = true;
        $taskList = new TaskList();
        try {
            $taskList->setTitle($this->getNombre());
            $taskListInstance = $servicio->tasklists->insert($taskList);
            $this->setId($taskListInstance->getId());
        } catch (Google_Exception $ex) {
            $result = false;
        }
        return ($result);
    }
    
    /**
     * Elimina una tasklist en Google Tasks asociada al objeto ListaReparto
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * 
     * @returns Booleano indicando si la acción tuvo éxito
     */

    public function elimina(Tasks $servicio): bool {
        $result = true;
        try {
            $servicio->tasklists->delete($this->getId());
        } catch (Google_Exception $ex) {
            $result = false;
        }
        return ($result);
    }

    /**
     * Ordena la ruta de reparto para entregar los repartos de una ListaReparto
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * @param ServicioMap $servicioMapa Acceso al API de Bing Maps
     * 
     * @returns Array con el orden adecuado de entrega. Las tasks también se reordenan en Google Tasks
     */
    
    public function ordena(Tasks $servicio, ServicioMap $servicioMapa) {
        if (count($this->getRepartos()) < 2) {
            $resultado = array_map(fn($x) => $x->getId(), $this->getRepartos());
        } else {
            $puntos = implode("|", array_map(fn($x) => "{$x->getLat()},{$x->getLon()}", $this->getRepartos()));
            $orden = $servicioMapa->ordenarRuta($puntos);
            $orden = array_map(fn($x) => $x - 1, $orden);
            for ($i = 0; $i < count($orden); $i++) {
                if ($i === 0) {
                    $servicio->tasks->move($this->getId(), $this->getRepartos()[$orden[$i]]->getId());
                } else {
                    $servicio->tasks->move($this->getId(), $this->getRepartos()[$orden[$i]]->getId(), ['previous' => $this->getRepartos()[$orden[$i - 1]]->getId()]);
                }
                $repartosAux[] = $this->getRepartos()[$orden[$i]];
            }
            ksort($repartosAux);
            $this->setRepartos($repartosAux);
            $resultado = array_map(fn($x) => $x->getId(), $this->getRepartos());
        }
        return ($resultado);
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getRepartos() {
        return $this->repartos;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setRepartos($repartos): void {
        $this->repartos = $repartos;
    }

}

?>