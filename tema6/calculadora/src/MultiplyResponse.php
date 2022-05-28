<?php

namespace App;

class MultiplyResponse
{

    /**
     * @var int $MultiplyResult
     */
    protected $MultiplyResult = null;

    /**
     * @param int $MultiplyResult
     */
    public function __construct($MultiplyResult)
    {
      $this->MultiplyResult = $MultiplyResult;
    }

    /**
     * @return int
     */
    public function getMultiplyResult()
    {
      return $this->MultiplyResult;
    }

    /**
     * @param int $MultiplyResult
     * @return \App\MultiplyResponse
     */
    public function setMultiplyResult($MultiplyResult)
    {
      $this->MultiplyResult = $MultiplyResult;
      return $this;
    }

}
