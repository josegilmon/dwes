<?php
namespace App;

use PDO;

class Producto
{
    private $id;
    private $nombre;
    private $nombreCorto;
    private $pvp;
    private $familia;
    private $descripcion;
    private $votos;
    private $valoracion;

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

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getNombreCorto() {
        return $this->nombre_corto;
    }

    public function getPvp() {
        return $this->pvp;
    }

    public function getFamilia() {
        return $this->familia;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getVotos() {
        return $this->votos;
    }

    public function getValoracion() {
        return $this->valoracion;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setNombreCorto($nombreCorto): void {
        $this->nombreCorto = $nombreCorto;
    }

    public function setPvp($pvp): void {
        $this->pvp = $pvp;
    }

    public function setFamilia($familia): void {
        $this->familia = $familia;
    }

    public function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    
    public static function recuperaProductos(PDO $bd): ?array
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select p.*, votos, valoracion from productos p "
                . "left join ("
                    . "select idPr, count(*) as votos, sum(cantidad)/count(*) as valoracion from votos group by idPr"
                . ") v on p.id = v.idPr "
                . "order by p.id";
        $sth = $bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $productos = $sth->fetchAll();
        return $productos;
    }
    
    public static function recuperaProductoPorId(PDO $bd, int $id): ?Producto
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from productos where id = :id";
        $sth = $bd->prepare($sql);
        $sth->execute([':id' => $id]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Producto::class);
        $producto = ($sth->fetch()) ?: null;
        return $producto;
    }
    
    public function persiste(PDO $bd) : bool
    {    
            if ($this->id) {
                $sql = "update productos set nombre = :nombre, nombre_corto = :nombre_corto, descripcion = :descripcion, pvp = :pvp, familia = :familia where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":nombre_corto" => $this->nombreCorto, ":descripcion" => $this->descripcion, ":pvp" => $this->pvp, ":familia" => $this->familia, ":id" => $this->id]);
            } else {
                $sql = "insert into productos (nombre, nombre_corto, descripcion, pvp, familia) values (:nombre, :nombre_corto, :descripcion, :pvp, :familia)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":nombre_corto" => $this->nombreCorto, ":descripcion" => $this->descripcion, ":pvp" => $this->pvp, ":familia" => $this->familia]);
                if ($result) {
                    $this->id = (int) $bd->lastInsertId();
                }
            }
            return ($result);
    }
    
    public function elimina(PDO $bd) : bool
    {
        $sql = "delete from productos where id = :id";
        $sth = $bd->prepare($sql);
        $result = $sth->execute([":id" => $this->id]);
        return $result;
    }
    

}

