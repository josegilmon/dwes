<?php
/**
 * Clase Calcula
 * 
 * Desarrollo Web en Entorno Servidor
 * Tema 6: Servicios web
 * Ejemplo: Documentación para generación 
 *          automática del documento WSDL
 * @author Víctor Lourido
*/

class Calcula {    
    /**
     * Suma dos números y devuelve el resultado
     * 
     * @param float $a
     * @param float $b
     * @return float
     */
    public function suma($a, $b){
        return $a+$b;
    }
    
    /**
     * Resta dos números y devuelve el resultado
     * 
     * @param float $a
     * @param float $b
     * @return float
     */
    public function resta($a, $b){
        return $a-$b;
    }
}
?>