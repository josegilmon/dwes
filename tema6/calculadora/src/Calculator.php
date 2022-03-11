<?php

namespace App;

class Calculator extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'Add' => 'App\\Add',
      'AddResponse' => 'App\\AddResponse',
      'Subtract' => 'App\\Subtract',
      'SubtractResponse' => 'App\\SubtractResponse',
      'Multiply' => 'App\\Multiply',
      'MultiplyResponse' => 'App\\MultiplyResponse',
      'Divide' => 'App\\Divide',
      'DivideResponse' => 'App\\DivideResponse',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = null)
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      if (!$wsdl) {
        $wsdl = 'http://www.dneonline.com/calculator.asmx?WSDL';
      }
      parent::__construct($wsdl, $options);
    }

    /**
     * Adds two integers. This is a test WebService. ©DNE Online
     *
     * @param Add $parameters
     * @return AddResponse
     */
    public function Add(Add $parameters)
    {
      return $this->__soapCall('Add', array($parameters));
    }

    /**
     * @param Subtract $parameters
     * @return SubtractResponse
     */
    public function Subtract(Subtract $parameters)
    {
      return $this->__soapCall('Subtract', array($parameters));
    }

    /**
     * @param Multiply $parameters
     * @return MultiplyResponse
     */
    public function Multiply(Multiply $parameters)
    {
      return $this->__soapCall('Multiply', array($parameters));
    }

    /**
     * @param Divide $parameters
     * @return DivideResponse
     */
    public function Divide(Divide $parameters)
    {
      return $this->__soapCall('Divide', array($parameters));
    }

}
