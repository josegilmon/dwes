<?php

class Familia {

    private $cod;
    private $nombre;

    public function __construct($cod = null, $nombre = null) {
        if (!is_null($cod)) {
            $this->cod = $cod;
        }
        if (!is_null($nombre)) {
            $this->$nombre = $nombre;
        }
    }

    public function getCod() {
        return $this->cod;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setCod($cod): void {
        $this->cod = $cod;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public static function recuperaFamilias(PDO $bd): ?array {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from familias order by nombre";
        $sth = $bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Familia::class);
        $familias = $sth->fetchAll();
        return $familias;
    }

}
