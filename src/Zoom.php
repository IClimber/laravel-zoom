<?php

namespace IClimber\Zoom;

use Exception;
use Illuminate\Support\Str;
use IClimber\Zoom\Interfaces\PrivateApplication;
use IClimber\Zoom\Interfaces\PublicApplication;

/**
 * Class Zoom
 * @package IClimber\Zoom
 *
 * @property-read User $user
 * @property-read Meeting $meeting
 * @property-read MeetingSetting $meetingSetting
 * @property-read Webinar $webinar
 * @property-read WebinarSetting $webinarSetting
 * @property-read Registrant $registrant
 * @property-read Recurrence $recurrence
 * @property-read Occurrence $occurrence
 * @property-read Panelist $panelist
 * @property-read CustomQuestion $customQuestion
 * @property-read GlobalDialInNumber $globalDialInNumber
 * @property-read TrackingField $trackingField
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
        $class = 'IClimber\Zoom\\' . Str::studly($key);
        if (class_exists($class)) {
            return new $class($this->client);
        }
        throw new Exception('Wrong method');
    }
}
