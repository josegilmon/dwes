<?php

namespace Clases;

class TareaOperacionesService extends \SoapClient {

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null) {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      if (!$wsdl) {
        $wsdl = 'http://dwes/tema6/tarea/servidorSoap/servicio.wsdl';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * Esta función recibe como parámetro el código de un producto y devuelve el PVP del mismo
     *
     * @param string $codigo
     * @return int
     */
    public function getPVP($codigo) {
      return $this->__soapCall('getPVP', array($codigo));
    }

    /**
     * Esta función recibe dos parámetros: el código de un producto y el código de una tienda. Devuelve el stock existente del producto en dicha tienda.
     *
     * @param string $codigo
     * @param string $tienda
     * @return int
     */
    public function getStock($codigo, $tienda) {
      return $this->__soapCall('getStock', array($codigo, $tienda));
    }

    /**
     * No recibe parámetros y devuelve un array con los códigos de todas las familias existentes.
     *
     * @return Array
     */
    public function getFamilias() {
      return $this->__soapCall('getFamilias', array());
    }

    /**
     * Recibe como parámetro el código de una familia y devuelve un array con los códigos de todos los productos de esa familia.
     *
     * @param string $familia
     * @return Array
     */
    public function getProductosFamilia($familia) {
      return $this->__soapCall('getProductosFamilia', array($familia));
    }

}
