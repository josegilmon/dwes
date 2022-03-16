<?php

namespace Tarea;

use PDO;

class Familia {

    private $cod;
    private $nombre;

    public function __construct(string $cod = null, string $nombre = null)
    {
        if (!is_null($cod)) {
            $this->cod = $cod;
        }
        if (!is_null($nombre)) {
            $this->nombre = $nombre;
        }
    }


    /**
     * Get the value of cod
     */ 
    public function getCod() {
        return $this->cod;
    }

    /**
     * Set the value of cod
     *
     * @return  self
     */ 
    public function setCod($cod) {
        $this->cod = $cod;

        return $this;
    }

    /**
     * Get the full name
     */ 
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }


    
    public static function recuperaFamilias(PDO $bd): ?array {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM familias";
        $sth = $bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Familia::class);
        return ($sth->fetchAll());
    }
    
    public function persiste(PDO $bd) : bool {    
        if ($this->cod) {
            $sql = "UPDATE familias SET nombre = :nombre WHERE cod = :cod";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":nombre" => $this->nombre, ":cod" => $this->cod]);
        } else {
            $sql = "INSERT INTO familias (cod, nombre) values (:cod, :nombre)";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":nombre" => $this->nombre, ":cod" => $this->cod]);
        }
        return ($result);
    }
    
    public function elimina(PDO $bd) : bool
    {
        $sql = "DELETE FROM familias WHERE cod = :cod";
        $sth = $bd->prepare($sql);
        return $sth->execute([":cod" => $this->cod]);
    }   

}

