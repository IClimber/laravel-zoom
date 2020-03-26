<?php

namespace MacsiDigital\Zoom;

use Exception;
use Illuminate\Support\Str;
use MacsiDigital\Zoom\Interfaces\PrivateApplication;
use MacsiDigital\Zoom\Interfaces\PublicApplication;

/**
 * Class Zoom
 * @package MacsiDigital\Zoom
 *
 * @property-read User $user
 */
class Zoom
{
    protected $client;

    public function __construct(string $userToken = null)
    {
        if (is_null($userToken)) {
            $this->bootPrivateApplication();
        } else {
            $this->bootPublicApplication($userToken);
        }
    }

    protected function bootPrivateApplication()
    {
        $this->client = (new PrivateApplication());
    }

    protected function bootPublicApplication(string $token)
    {
        $this->client = (new PublicApplication($token));
    }

    public function getClient()
    {
        return $this->client;
    }

    public function __get($key)
    {
        return $this->getNode($key);
    }

    protected function getNode($key)
    {
        $class = 'MacsiDigital\Zoom\\' . Str::studly($key);
        if (class_exists($class)) {
            return new $class($this->client);
        }
        throw new Exception('Wrong method');
    }
}
