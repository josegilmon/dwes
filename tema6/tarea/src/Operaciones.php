<?php

namespace Tarea;

use Tarea\Conexion;
use Tarea\Producto;

class Operaciones {

    /**
     * Esta función recibe como parámetro el código de un producto y devuelve el PVP del mismo
     * 
     * @param string $codigo
     * @return int
     */
    public function getPVP($codigo) {
        
        $bd = Conexion::getConexion();
        $producto = Producto::recuperaProducto($bd, $codigo);

        return $producto->getPVP();
    }

    /**
     * Esta función recibe dos parámetros: el código de un producto y el código de una tienda. Devuelve el stock existente del producto en dicha tienda.
     * 
     * @param string $codigo
     * @param string $tienda
     * @return int
     */
    public function getStock($codigo, $tienda) {
        $stock = 0;
        return $stock;
    }

    // No recibe parámetros y devuelve un array con los códigos de todas las familias existentes.
    public function getFamilias() {
        return [];
    }

    // Recibe como parámetro el código de una familia y devuelve un array con los códigos de todos los productos de esa familia.
    public function getProductosFamilia($familia) {
        $productos = [];
        return $productos;
    }

}

?>