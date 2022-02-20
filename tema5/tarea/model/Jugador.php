<?php
namespace App;

use PDO;
use App\Datos;
use Faker\Factory;

class Jugador {

    private $id;
    private $nombre;
    private $apellidos;
    private $dorsal;
    private $posicion;
    private $barcode;

    public function __construct(string $nombre = null, string $apellidos = null, int $dorsal = null, string $posicion = null, string $barcode = null)
    {
        if (!is_null($nombre)) {
            $this->nombre = $nombre;
        }
        if (!is_null($apellidos)) {
            $this->apellidos = $apellidos;
        }
        if (!is_null($dorsal)) {
            $this->dorsal = $dorsal;
        }
        if (!is_null($posicion)) {
            $this->posicion = $posicion;
        }
        if (!is_null($barcode)) {
            $this->barcode = $barcode;
        }
    }

    /**
     * Get the full name
     */ 
    public function getNombreCompleto() {
        return $this->nombre ." ". $this->apellidos;
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
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of dorsal
     */ 
    public function getDorsal() {
        return $this->dorsal;
    }

    /**
     * Set the value of dorsal
     *
     * @return  self
     */ 
    public function setDorsal($dorsal) {
        $this->dorsal = $dorsal;

        return $this;
    }

    /**
     * Get the value of posicion
     */ 
    public function getPosicion() {
        return $this->posicion;
    }

    /**
     * Set the value of posicion
     *
     * @return  self
     */ 
    public function setPosicion($posicion) {
        $this->posicion = $posicion;

        return $this;
    }

    /**
     * Get the value of barcode
     */ 
    public function getBarcode() {
        return $this->barcode;
    }

    /**
     * Set the value of barcode
     *
     * @return  self
     */ 
    public function setBarcode($barcode) {
        $this->barcode = $barcode;

        return $this;
    }

    public static function creaJugador(int $dorsal): ?Jugador {
        
        $faker = Factory::create('es_ES');
        $nombre = $faker->firstName();
        $apellidos = $faker->lastName();
        // $dorsal = $faker->numberBetween(0, 100);
        $posicion = $faker->randomElement(Datos::POSICIONES);
        $barcode = $faker->ean13();

        return new Jugador($nombre, $apellidos, $dorsal, $posicion, $barcode);
    }

    
    public static function recuperaJugadores(PDO $bd): ?array
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from jugadores order by apellidos";
        $sth = $bd->prepare($sql);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, Jugador::class);
        return $sth->fetchAll();
    }
    
    public static function recuperaJugadorPorDorsal(PDO $bd, int $dorsal): ?Jugador
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from jugadores where dorsal = :dorsal";
        $sth = $bd->prepare($sql);
        $sth->execute([':dorsal' => $dorsal]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Jugador::class);
        return ($sth->fetch()) ?: null;
    }
    
    public static function recuperaJugadorPorBarcode(PDO $bd, string $barcode): ?Jugador
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = "select * from jugadores where barcode = :barcode";
        $sth = $bd->prepare($sql);
        $sth->execute([':barcode' => $barcode]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Jugador::class);
        return ($sth->fetch()) ?: null;
    }
    
    public function persiste(PDO $bd) : bool
    {    
            if ($this->id) {
                $sql = "update jugadores set nombre = :nombre, apellidos = :apellidos, dorsal = :dorsal, posicion = :posicion, barcode = :barcode where id = :id";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":apellidos" => $this->apellidos, ":dorsal" => $this->dorsal, ":posicion" => $this->posicion, ":barcode" => $this->barcode, ":id" => $this->id]);
            } else {
                $sql = "insert into jugadores (nombre, apellidos, dorsal, posicion, barcode) values (:nombre, :apellidos, :dorsal, :posicion, :barcode)";
                $sth = $bd->prepare($sql);
                $result = $sth->execute([":nombre" => $this->nombre, ":apellidos" => $this->apellidos, ":dorsal" => $this->dorsal, ":posicion" => $this->posicion, ":barcode" => $this->barcode]);
                if ($result) {
                    $this->id = (int) $bd->lastInsertId();
                }
            }
            return ($result);
    }
    
    public function elimina(PDO $bd) : bool
    {
        $sql = "delete from jugadores where id = :id";
        $sth = $bd->prepare($sql);
        return $sth->execute([":id" => $this->id]);
    }   

}

