<?php

namespace IClimber\Zoom\Interfaces;

use IClimber\Zoom\Support\Request;

class PublicApplication extends Base
{
    protected $request;

    public function __construct(string $token)
    {
        $this->request = (new Request)->bootPublicApplication($token);
    }
}
