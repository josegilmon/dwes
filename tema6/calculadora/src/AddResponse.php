<?php

namespace App;

class AddResponse
{

    /**
     * @var int $AddResult
     */
    protected $AddResult = null;

    /**
     * @param int $AddResult
     */
    public function __construct($AddResult)
    {
      $this->AddResult = $AddResult;
    }

    /**
     * @return int
     */
    public function getAddResult()
    {
      return $this->AddResult;
    }

    /**
     * @param int $AddResult
     * @return \App\AddResponse
     */
    public function setAddResult($AddResult)
    {
      $this->AddResult = $AddResult;
      return $this;
    }

}
