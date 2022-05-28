<?php
namespace App;

use PDO;

class Voto
{
    private $idPr;
    private $idUs;
    private $cantidad;

    public function __construct(int $idPr = null, string $idUs = null, int $cantidad = null)
    {
        if (!is_null($idPr)) {
            $this->idPr = $idPr;
        }
        if (!is_null($idUs)) {
            $this->idUs = $idUs;
        }
        if (!is_null($cantidad)) {
            $this->cantidad = $cantidad;
        }
    }

    public function getIdPr() {
        return $this->idPr;
    }

    public function getIdUs() {
        return $this->idUs;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setIdPr($idPr): void {
        $this->idPr = $idPr;
    }

    public function setIdUs($idUs): void {
        $this->idUs = $idUs;
    }

    public function setCantidad($cantidad): void {
        $this->cantidad = $cantidad;
    }

    
    public static function recuperaVotosPorProducto(PDO $bd, int $idPr): ?array {

        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from votos where idPr = :idPr";
        $sth = $bd->prepare($sql);
        $sth->execute([':idPr' => $idPr]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Voto::class);
        return $sth->fetchAll();
    }

    public static function recuperaValoracionMediaPorProducto(PDO $bd, int $idPr): ?Voto {

        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select 1 as idPr, '' as idUs, sum(cantidad)/count(*) as cantidad from votos where idPr = :idPr";
        $sth = $bd->prepare($sql);
        $sth->execute([':idPr' => $idPr]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Voto::class);
        return ($sth->fetch()) ?: null;
    }

    public function compruebaVotoPorProductoUsuario(PDO $bd): ?Voto {

        if ($this->idPr && $this->idUs) {
            $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
            $sql = "select * from votos where idPr = :idPr and idUs = :idUs";
            $sth = $bd->prepare($sql);
            $sth->execute([':idPr' => $this->idPr, ':idUs' => $this->idUs]);
            $sth->setFetchMode(PDO::FETCH_CLASS, Voto::class);
            return ($sth->fetch()) ?: null;
        }
        return null;
    }

    public function persiste(PDO $bd) : bool {    

        $sql = "insert into votos (idPr, idUs, cantidad) values (:idPr, :idUs, :cantidad)";
        $sth = $bd->prepare($sql);
        $result = $sth->execute([":idPr" => $this->idPr, ":idUs" => $this->idUs, ":cantidad" => $this->cantidad]);
        return ($result);
    }

}

