<?php

namespace IClimber\Zoom;

use Exception;
use Illuminate\Support\Collection;
use IClimber\Zoom\Exceptions\RequestException;
use IClimber\Zoom\Support\Model;

class Webinar extends Model
{
    const ENDPOINT = 'webinars';
    const NODE_NAME = 'webinar';
    const KEY_FIELD = 'id';

    protected $methods = ['get', 'post', 'patch', 'put', 'delete'];

    protected $userID = null;

    protected $attributes = [
        'uuid' => null, // string
        'id' => null, // string
        'host_id' => null, // string
        'created_at' => null, // string [date-time]
        'join_url' => null, // string
        'topic' => null, // string
        'type' => null, // integer
        'start_time' => null, // string [date-time]
        'duration' => null, // integer
        'timezone' => null, // string
        'password' => null, // string
        'agenda' => null, // string
        'recurrence' => [],
        'occurrences' => [],
        'settings' => [],
    ];

    protected $createAttributes = [
        'topic',
        'type',
        'start_time',
        'duration',
        'timezone',
        'password',
        'agenda',
        'recurrence',
        'settings',
    ];

    protected $updateAttributes = [
        'topic',
        'type',
        'start_time',
        'duration',
        'timezone',
        'password',
        'agenda',
        'recurrence',
        'settings',
    ];

    protected $relationships = [
        'settings' => WebinarSetting::class,
        'recurrence' => Recurrence::class,
        'occurrences' => Occurrence::class,
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

    public function addSettings(WebinarSetting $settings)
    {
        $this->attributes['settings'] = $settings;

        return $this;
    }

    public function addOccurrence(Occurrence $occurrence)
    {
        $this->attributes['occurrences'][] = $occurrence;

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
                    throw new RequestException($this->response->getStatusCode() . ' status code');
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
                    throw new RequestException($this->response->getStatusCode() . ' status code');
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
                    throw new RequestException($this->response->getStatusCode() . ' status code');
                }
            }
        } else {
            if (in_array('post', $this->methods)) {
                $this->response = $this->client->post("users/{$this->userID}/{$this->getEndPoint()}", $this->createAttributes());
                if ($this->response->getStatusCode() == 201) {
                    $this->fill($this->response->getBody());

                    return $this;
                } else {
                    throw new RequestException($this->response->getStatusCode() . ' status code');
                }
            }
        }
    }

    public function registrants()
    {
        $registrant = new Registrant($this->client);
        $registrant->setType('webinars');
        $registrant->setRelationshipID($this->getID());

        return $registrant;
    }

    public function panelists()
    {
        $panelist = new Panelist($this->client);
        $panelist->setWebinarID($this->getID());

        return $panelist;
    }

    public function cancelRegistrant($registrant)
    {
        $this->response = $this->client->put("/webinars/{$this->getID()}/registrants/status", ['action' => 'cancel', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 204) {
            return $this->response->getBody();
        } else {
            throw new RequestException($this->response->getStatusCode() . ' status code');
        }
    }

    public function denyRegistrant($registrant)
    {
        $this->response = $this->client->put("/webinars/{$this->getID()}/registrants/status", ['action' => 'deny', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 204) {
            return $this->response->getBody();
        } else {
            throw new RequestException($this->response->getStatusCode() . ' status code');
        }
    }

    public function approveRegistrant($registrant)
    {
        $this->response = $this->client->put("/webinars/{$this->getID()}/registrants/status", ['action' => 'approve', 'registrant' => [['email' => $registrant->email]]]);
        if ($this->response->getStatusCode() == 204) {
            return $this->response->getBody();
        } else {
            throw new RequestException($this->response->getStatusCode() . ' status code');
        }
    }

    public function deletePanelist($panelist)
    {
        $this->response = $this->client->delete("/webinars/{$this->getID()}/panelists/{$panelist->id}");
        if ($this->response->getStatusCode() == 204) {
            return $this->response->getBody();
        } else {
            throw new RequestException($this->response->getStatusCode() . ' status code');
        }
    }

    public function deletePanelists()
    {
        $this->response = $this->client->delete("/webinars/{$this->getID()}/panelists");
        if ($this->response->getStatusCode() == 204) {
            return $this->response->getBody();
        } else {
            throw new RequestException($this->response->getStatusCode() . ' status code');
        }
    }
}
