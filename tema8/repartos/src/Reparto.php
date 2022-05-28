<?php

namespace App;

use Google\Service\Tasks;
use Google\Service\Tasks\Task;

/**
 * Reparto representa un reparto
 */
class Reparto {

    /**
     * Identificador de la lista de reparto que corresponde al identificador de la tasklist en Google Tasks
     */
    private $listaRepartoId = null;

    /**
     * Identificador del reparto que corresponde al identificador de la task en Google Tasks
     */
    private $id = null;

    private ?string $direccion;
    private ?string $producto;
    private ?float $lat;
    private ?float $lon;

    /**
     * Constructor de la clase ListaReparto
     * 
     * @param string $direccion Dirección del reparto
     * @param string $producto Producto del reparto
     * @param string $lat Latitude del destino del reparto
     * @param string $lon Longitud del destino del reparto
     * 
     * @returns Reparto
     */
    public function __construct(string $direccion = null, string $producto = null, float $lat = null, float $lon = null) {
        $this->direccion = $direccion;
        $this->producto = $producto;
        $this->lat = $lat;
        $this->lon = $lon;        
    }

    /**
     * Recupera un objeto Reparto dado el identificador de la tasklist y la task en Google Tasks
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * @param string $id Identificador de la tasklist
     * @param string $id Identificador de la task
     * 
     * @returns Objeto Reparto asociado al identificador de la tasklist y la task
     */
    public static function recuperaReparto(Tasks $servicio, string $listaRepartoId, string $repartoId): ?Reparto {
        $task = $servicio->tasks->get($listaRepartoId, $repartoId);
        $campos = explode("&", $task->getTitle());
        $coord = explode("&", $task->getNotes());
        $reparto = new Self(trim($campos[1]), trim($campos[0]), trim($coord[0]), trim($coord[1]));
        $reparto->setListaRepartoId($listaRepartoId);
        $reparto->setId($repartoId);
        return ($reparto);
    }

    /**
     * Persiste un objeto Reparto creando una task en Google Tasks
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * 
     * @returns Booleano indicando si la acción tuvo éxito
     */
    public function persiste(Tasks $servicio): bool {
        $result = true;
        $note = $this->getLat() . "&" . $this->getLon();
        $title = ucwords($this->getProducto()) . " & " . ucwords($this->getDireccion());
        $op = ['title' => $title, 'notes' => $note];
        $task = new Task($op);
        try {
            $taskInstance = $servicio->tasks->insert($this->getListaRepartoId(), $task);
            $this->setId($taskInstance->getId());
        } catch (Google_Exception $ex) {
            $result = false;
        }
        return ($result);
    }

    /**
     * Elimina una task en Google Tasks asociada al objeto Reparto
     * 
     * @param Tasks $servicio Acceso al API de Google Tasks
     * 
     * @returns Booleano indicando si la acción tuvo éxito
     */
    public function elimina(Tasks $servicio): bool {
        $result = true;
        try {
            $servicio->tasks->delete($this->getListaRepartoId(), $this->getId());
        } catch (Google_Exception $ex) {
            $result = false;
        }
        return ($result);
    }

    public function getListaRepartoId() {
        return $this->listaRepartoId;
    }

    public function getId() {
        return $this->id;
    }

    public function getDireccion(): string {
        return $this->direccion;
    }

    public function getProducto(): string {
        return $this->producto;
    }

    public function getLat(): float {
        return $this->lat;
    }

    public function getLon(): float {
        return $this->lon;
    }

    public function setListaRepartoId($listaRepartoId): void {
        $this->listaRepartoId = $listaRepartoId;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    public function setProducto(string $producto): void {
        $this->producto = $producto;
    }

    public function setLat(float $lat): void {
        $this->lat = $lat;
    }

    public function setLon(float $lon): void {
        $this->lon = $lon;
    }

}

?>