<?php

namespace Tarea;

use Tarea\Conexion;
use Tarea\Producto;
use Tarea\Familia;
use Tarea\Stock;

class Operaciones {

    /**
     * Esta función recibe como parámetro el código de un producto y devuelve el PVP del mismo
     * 
     * @soap
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
     * @soap
     * @param string $codigo
     * @param string $tienda
     * @return int
     */
    public function getStock($codigo, $tienda) {

        $bd = Conexion::getConexion();
        $stock = Stock::recuperaStockPorProductoyTienda($bd, $codigo, $tienda);

        return $stock->getUnidades();
    }

    /**
     * No recibe parámetros y devuelve un array con los códigos de todas las familias existentes.
     * 
     * @soap
     * @return array
     */
    public function getFamilias() {

        $bd = Conexion::getConexion();
        $familias = Familia::recuperaFamilias($bd);
        
        return $familias;
    }

    /**
     * Recibe como parámetro el código de una familia y devuelve un array con los códigos de todos los productos de esa familia.
     * 
     * @soap
     * @param string $familia
     * @return array
     */
    public function getProductosFamilia($familia) {
        
        $bd = Conexion::getConexion();
        $productos = Producto::recuperaProductosPorFamilia($bd, $familia);
        
        return $productos;
    }

}

?>