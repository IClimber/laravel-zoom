<?php

namespace IClimber\Zoom;

use Exception;
use Illuminate\Support\Collection;
use IClimber\Zoom\Exceptions\RequestException;
use IClimber\Zoom\Support\Model;

/**
 * Class Meeting
 * @package IClimber\Zoom
 *
 * @property-read string $uuid
 * @property-read string $id
 * @property-read string $host_id
 * @property-read string $created_at
 * @property-read string $join_url
 * @property-read string $start_url
 * @property string $topic
 * @property integer $type
 * @property-read string $status
 * @property string $start_time
 * @property integer $duration
 * @property string $timezone
 * @property string $password
 * @property string $agenda
 * @property Recurrence|array $recurrence
 * @property Occurrence|array $occurrences
 * @property TrackingField|array $tracking_fields
 * @property MeetingSetting|array $settings
 */
class Meeting extends Model
{
    const ENDPOINT = 'meetings';
    const NODE_NAME = 'meeting';
    const KEY_FIELD = 'id';

    protected $methods = ['get', 'post', 'patch', 'put', 'delete'];

    protected $userID = null;

    public $response;

    protected $attributes = [
        'uuid' => null,
        'id' => null, // string
        'host_id' => null, // string
        'created_at' => null, // string [date-time]
        'join_url' => null, // string
        'topic' => null, // string
        'type' => null, // integer
        'status' => null, // string
        'start_time' => null, // string [date-time]
        'duration' => null, // integer
        'timezone' => null, // string
        'password' => null, // string
        'agenda' => null, // string
        'start_url' => null, // string
        'recurrence' => [],
        'occurrences' => [],
        'tracking_fields' => [],
        'settings' => [],
    ];

    protected $createAttributes = [
        'schedule_for',
        'topic',
        'type',
        'start_time',
        'duration',
        'timezone',
        'password',
        'agenda',
        'tracking_fields',
        'recurrence',
        'settings',
    ];

    protected $updateAttributes = [
        'schedule_for',
        'topic',
        'type',
        'start_time',
        'duration',
        'timezone',
        'password',
        'agenda',
        'tracking_fields',
        'recurrence',
        'settings',
    ];

    protected $relationships = [
        'settings' => MeetingSetting::class,
        'recurrence' => Recurrence::class,
        'tracking_fields' => TrackingField::class,
    ];

    public function addTrackingField(TrackingField $tracking_field)
    {
        $this->attributes['tracking_fields'][] = $tracking_field;

        return $this;
    }

    public function addRecurrence(Recurrence $recurrence)
    {
        $this->attributes['recurrence'] = $recurrence;

        return $this;
    }

    public function addSettings(MeetingSetting $settings)
    {
        $this->attributes['settings'] = $settings;

        return $this;
    }

    public function setUserID($user_id)
    {
        $this->userID = $user_id;

        return $this;
    }

    public function make($attributes)
    {
        $model = new static($this->client);
        $model->fill($attributes);
        if (isset($this->userID) && !is_null($this->userID)) {
            $model->setUserID($this->userID);
        }

        return $model;
    }

    public function get()
    {
        if (!is_null($this->userID)) {
            if (in_array('get', $this->methods)) {
                $this->response = $this->client->get("users/{$this->userID}/" . $this->getEndPoint() . $this->getQueryString());
                if ($this->response->getStatusCode() == 200) {
                    return $this->collect($this->response->getBody());
                } else {
                    throw $this->getExceptionByResponse($this->response);
                }
            }
        } else {
            throw new Exception('No User to retrieve Meetings');
        }
    }

    public function all($fromPage = 1): Collection
    {
        if (!is_null($this->userID)) {
            if (in_array('get', $this->methods)) {
                $this->response = $this->client->get("users/{$this->userID}/" . $this->getEndPoint());
                if ($this->response->getStatusCode() == 200) {
                    return $this->collect($this->response->getBody());
                } else {
                    throw $this->getExceptionByResponse($this->response);
                }
            }
        } else {
            throw new Exception('No User to retrieve Meetings');
        }
    }

    public function save()
    {
        if ($this->hasID()) {
            if (in_array('put', $this->methods) || in_array('patch', $this->methods)) {
                $this->response = $this->client->patch("{$this->getEndpoint()}/{$this->getID()}", $this->updateAttributes());
                if ($this->response->getStatusCode() == 204) {
                    return $this;
                } else {
                    throw $this->getExceptionByResponse($this->response);
                }
            }
        } else {
            if (in_array('post', $this->methods)) {
                $this->response = $this->client->post("users/{$this->userID}/{$this->getEndPoint()}", $this->createAttributes());
                if ($this->response->getStatusCode() == 201) {
                    $this->fill($this->response->getBody());

                    return $this;
                } else {
                    throw $this->getExceptionByResponse($this->response);
                }
            }
        }
    }

    public function registrants()
    {
        $registrant = new Registrant($this->client);
        $registrant->setType('meetings');
        $registrant->setRelationshipID($this->getID());

        return $registrant;
    }

    public function deleteRegistrant($registrant)
    {
        $this->response = $this->client->put("/meetings/{$this->getID()}/registrants/status", ['action' => 'cancel', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 200) {
            return $this->response->getBody();
        } else {
            throw $this->getExceptionByResponse($this->response);
        }
    }

    public function denyRegistrant($registrant)
    {
        $this->response = $this->client->put("/meetings/{$this->getID()}/registrants/status", ['action' => 'deny', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 200) {
            return $this->response->getBody();
        } else {
            throw $this->getExceptionByResponse($this->response);
        }
    }

    public function approveRegistrant($registrant)
    {
        $this->response = $this->client->put("/meetings/{$this->getID()}/registrants/status", ['action' => 'approve', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 200) {
            return $this->response->getBody();
        } else {
            throw $this->getExceptionByResponse($this->response);
        }
    }
}
