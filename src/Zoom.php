<?php

namespace IClimber\Zoom;

use Exception;
use GuzzleHttp\Client;
use IClimber\Zoom\Interfaces\PrivateApplication;
use IClimber\Zoom\Interfaces\PublicApplication;
use Illuminate\Support\Str;

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

    public static function getUserAccessData(string $code, string $redirect_uri, string $grant_type = 'authorization_code')
    {
        $options = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('zoom.client_id') . ':' . config('zoom.client_secret')),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];

        $params = [
            'grant_type' => $grant_type,
            'code' => $code,
            'redirect_uri' => $redirect_uri
        ];

        $response = (new Client($options))->post('https://zoom.us/oauth/token', [
            'form_params' => $params
        ]);

        return $response->getBody()->getContents();
    }

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
