<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Exceptions\RequestException;
use IClimber\Zoom\Support\Model;

class User extends Model
{
    const ENDPOINT = 'users';
    const NODE_NAME = 'user';
    const KEY_FIELD = 'id';

    protected $methods = ['get', 'post', 'patch', 'put', 'delete'];

    protected $queryAttributes = ['status', 'limit', 'role_id'];

    protected $attributes = [
        'first_name' => null, //string
        'last_name' => null, //string
        'email' => null, //string
        'type' => null, //integer
        'pmi' => null, //string
        'use_pmi' => null,
        'timezone' => null, //string
        'dept' => null, //string
        'created_at' => null, //string [date-time]
        'last_login_time' => null, //string [date-time]
        'last_client_version' => null, //string
        'language' => null,
        'phone_country' => null,
        'phone_number' => null,
        'vanity_url' => null, // string
        'personal_meeting_url' => null, // string
        'verified' => null, // integer
        'pic_url' => null, // string
        'cms_user_id' => null, // string
        'account_id' => null, // string
        'host_key' => null, // string
        'status' => null,
        'group_ids' => [],
        'im_group_ids' => [],
        'password' => null,
        'id' => null,
        'jid' => null,
    ];

    protected $createAttributes = [
        'first_name',
        'last_name',
        'email',
        'type',
        'password',
    ];

    protected $updateAttributes = [
        'first_name',
        'last_name',
        'type',
        'pmi',
        'use_pmi',
        'timezone',
        'dept',
        'language',
        'dept',
        'vanity_name',
        'host_key',
        'cms_user_id',
    ];

    public function save()
    {
        if ($this->hasID()) {
            if (in_array('put', $this->methods)) {
                $this->response = $this->client->patch("{$this->getEndpoint()}/{$this->getID()}", $this->updateAttributes());
                if ($this->response->getStatusCode() == 200) {
                    return $this;
                } else {
                    throw new RequestException($this->response->getStatusCode() . ' status code');
                }
            }
        } else {
            if (in_array('post', $this->methods)) {
                $attributes = ['action' => 'create', 'user_info' => $this->createAttributes()];
                $this->response = $this->client->post($this->getEndpoint(), $attributes);
                if ($this->response->getStatusCode() == 200) {
                    $this->fill($this->response->getBody());

                    return $this;
                } else {
                    throw new RequestException($this->response->getStatusCode() . ' status code');
                }
            }
        }
    }

    public function meetings(): Meeting
    {
        $meeting = new Meeting($this->client);
        $meeting->setUserID($this->getID());

        return $meeting;
    }

    public function webinars(): Webinar
    {
        $webinar = new Webinar($this->client);
        $webinar->setUserID($this->getID());

        return $webinar;
    }
}
