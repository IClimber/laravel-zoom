<?php

namespace IClimber\Zoom\Interfaces;

use IClimber\Zoom\Support\Request;

class PrivateApplication extends Base
{
    protected $request;

    public function __construct()
    {
        $this->request = (new Request)->bootPrivateApplication();
    }
}
