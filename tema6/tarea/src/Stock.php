<?php

namespace Tarea;

use PDO;

class Stock {

    private $producto;
    private $tienda;
    private $unidades;

    public function __construct(string $producto = null, string $tienda = null, string $unidades = null) {
        if (!is_null($producto)) {
            $this->producto = $producto;
        }
        if (!is_null($tienda)) {
            $this->tienda = $tienda;
        }
        if (!is_null($unidades)) {
            $this->unidades = $unidades;
        }
    }


    /**
     * Get the product ID
     */ 
    public function getProducto() {
        return $this->producto;
    }

    /**
     * Set the product ID
     *
     * @return  self
     */ 
    public function setProducto($producto) {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get the shop ID
     */ 
    public function getTienda() {
        return $this->tienda;
    }

    /**
     * Set the value of shop ID
     *
     * @return  self
     */ 
    public function setTienda($tienda) {
        $this->tienda = $tienda;

        return $this;
    }

    /**
     * Get the value of unidades
     */ 
    public function getUnidades() {
        return $this->unidades;
    }

    /**
     * Set the value of unidades
     *
     * @return  self
     */ 
    public function setUnidades($unidades) {
        $this->unidades = $unidades;

        return $this;
    }

    
    public static function recuperaStockPorProducto(PDO $bd, int $producto): ?array {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM stock where producto = :producto";
        $sth = $bd->prepare($sql);
        $sth->execute([':producto' => $producto]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Stock::class);
        return ($sth->fetchAll());
    }
    
    public static function recuperaStockPorFamilia(PDO $bd, string $familia): ?array {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "SELECT * FROM productos where familia = :familia";
        $sth = $bd->prepare($sql);
        $sth->execute([':familia' => $familia]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Stock::class);
        return ($sth->fetchAll());
    }
    
    public function persiste(PDO $bd) : bool {    
        if ($this->id) {
            $sql = "UPDATE productos SET producto = :producto, tienda = :tienda, unidades = :unidades, pvp = :pvp, familia = :familia WHERE id = :id";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":producto" => $this->producto, ":tienda" => $this->tienda, ":unidades" => $this->unidades, ":pvp" => $this->pvp, ":familia" => $this->familia, ":id" => $this->id]);
        } else {
            $sql = "INSERT INTO productos (producto, tienda, unidades, pvp, familia) values (:producto, :tienda, :unidades, :pvp, :familia)";
            $sth = $bd->prepare($sql);
            $result = $sth->execute([":producto" => $this->producto, ":tienda" => $this->tienda, ":unidades" => $this->unidades, ":pvp" => $this->pvp, ":familia" => $this->familia]);
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

