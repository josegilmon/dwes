<?php

namespace Tarea;

use PDO;

class Producto {

    private $id;
    private $nombre;
    private $nombre_corto;
    private $descripcion;
    private $pvp;
    private $familia;

    public function __construct(string $nombre = null, string $nombreCorto = null, string $descripcion = null, float $pvp = null, string $familia = null)
    {
        if (!is_null($nombre)) {
            $this->nombre = $nombre;
        }
        if (!is_null($nombreCorto)) {
            $this->nombreCorto = $nombreCorto;
        }
        if (!is_null($descripcion)) {
            $this->descripcion = $descripcion;
        }
        if (!is_null($pvp)) {
            $this->pvp = $pvp;
        }
        if (!is_null($familia)) {
            $this->familia = $familia;
        }
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

    /**
     * Get the short name
     */ 
    public function getNombreCorto() {
        return $this->nombre_corto;
    }

    /**
     * Set the value of nombreCorto
     *
     * @return  self
     */ 
    public function setNombreCorto($nombreCorto) {
        $this->nombre_corto = $nombreCorto;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of pvp
     */ 
    public function getPVP() {
        return $this->pvp;
    }

    /**
     * Set the value of pvp
     *
     * @return  self
     */ 
    public function setPVP($pvp) {
        $this->pvp = $pvp;

        return $this;
    }

    /**
     * Get the value of familia
     */ 
    public function getFamilia() {
        return $this->familia;
    }

    /**
     * Set the value of familia
     *
     * @return  self
     */ 
    public function setFamilia($familia) {
        $this->familia = $familia;

        return $this;
    }

    
    public static function recuperaProducto(PDO $bd, int $codigo): ?Producto {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM productos where id = :id";
        $sth = $bd->prepare($sql);
        $sth->execute([':id' => $codigo]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        return ($sth->fetch()) ?: null;
    }
    
    public static function recuperaProductosPorFamilia(PDO $bd, string $familia): ?array {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM productos where familia = :familia";
        $sth = $bd->prepare($sql);
        $sth->execute([':familia' => $familia]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        return ($sth->fetchAll());
    }
    
    public function persiste(PDO $bd) : bool {    
        if ($this->id) {
            $sql = "UPDATE productos SET nombre = :nombre, nombreCorto = :nombreCorto, descripcion = :descripcion, pvp = :pvp, familia = :familia WHERE id = :id";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":nombre" => $this->nombre, ":nombreCorto" => $this->nombreCorto, ":descripcion" => $this->descripcion, ":pvp" => $this->pvp, ":familia" => $this->familia, ":id" => $this->id]);
        } else {
            $sql = "INSERT INTO productos (nombre, nombreCorto, descripcion, pvp, familia) values (:nombre, :nombreCorto, :descripcion, :pvp, :familia)";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":nombre" => $this->nombre, ":nombreCorto" => $this->nombreCorto, ":descripcion" => $this->descripcion, ":pvp" => $this->pvp, ":familia" => $this->familia]);
            if ($result) {
                $this->id = (int) $bd->lastInsertId();
            }
        }
        return ($result);
    }
    
    public function elimina(PDO $bd) : bool
    {
        $sql = "DELETE FROM productos WHERE id = :id";
        $sth = $bd->prepare($sql);
        return $sth->execute([":id" => $this->id]);
    }   

}

