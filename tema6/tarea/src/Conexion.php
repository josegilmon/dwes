<?php

namespace Tarea;

use PDO;

class Conexion {

    const DB_HOST = '127.0.0.1';
    const DB_PORT = '3306';
    const DB_DATABASE = 'tarea6';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';

    protected static $bd = null;
    protected static $instance = null;
    
    private function __construct() {
        self::$bd = new PDO("mysql:host=" . Conexion::DB_HOST . ";dbname=" . Conexion::DB_DATABASE, Conexion::DB_USERNAME, Conexion::DB_PASSWORD);
        self::$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getConexion() {
        if (!self::$bd) {
            new Conexion();
        }
        return self::$bd;
    }

    public function cerrar(&$con) {
        $con = null;
    }
    
    public function cerrarTodo(&$con, &$st) {
        $st = null;
        $con = null;
    }
    
}
?>