<?php

namespace IClimber\Zoom;

use Exception;
use GuzzleHttp\Client;
use IClimber\Zoom\Exceptions\InvalidAccessTokenException;
use IClimber\Zoom\Exceptions\RequestException;
use IClimber\Zoom\Interfaces\PrivateApplication;
use IClimber\Zoom\Interfaces\PublicApplication;
use IClimber\Zoom\Support\Response;
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
    const TOKEN_ENDPOINT = 'https://zoom.us/oauth/token';

    protected $client;

    public static function getUserAccessData(string $code, string $redirect_uri)
    {
        $options = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('zoom.client_id') . ':' . config('zoom.client_secret')),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];

        $params = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri
        ];

        try {
            $response = new Response((new Client($options))->post(self::TOKEN_ENDPOINT, [
                'form_params' => $params
            ]));
        } catch (Exception $exception) {
            $response = new Response($exception->getResponse());
        }

        if ($response->getStatusCode() != 200) {
            throw new RequestException($response->getStatusCode() . ' status code');
        }

        return $response->getBody();
    }

    public static function refreshToken(string $refresh_token)
    {
        $options = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode(config('zoom.client_id') . ':' . config('zoom.client_secret')),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ];

        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        ];

        try {
            $response = new Response((new Client($options))->post(self::TOKEN_ENDPOINT, [
                'form_params' => $params
            ]));
        } catch (Exception $exception) {
            $response = new Response($exception->getResponse());
        }

        if ($response->getStatusCode() == 401) {
            throw new InvalidAccessTokenException($response->getBody()['reason'] ?? 'Invalid Token!');
        }

        return $response->getBody();
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
