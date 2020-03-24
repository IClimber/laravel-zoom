<?php

namespace MacsiDigital\Zoom\Interfaces;

use MacsiDigital\Zoom\Support\Request;

class PublicApplication extends Base
{
    protected $request;

    public function __construct(string $token)
    {
        $this->request = (new Request)->bootPublicApplication($token);
    }
}
