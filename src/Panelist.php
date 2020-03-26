<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class Panelist extends Model
{
    public $webinar_id;

    const KEY_FIELD = 'id';

    protected $attributes = [
        'id' => null, // string
        'name' => null, // string
        'email' => null, // string
        'join_url' => null, // string
    ];

    protected $createAttributes = [
        'id',
        'name',
        'email',
        'join_url',
    ];

    protected $updateAttributes = [
        'id',
        'name',
        'email',
        'join_url',
    ];

    public function setWebinarID($webinar_id)
    {
        $this->webinarID = $webinar_id;
    }

    public function make($attributes)
    {
        $model = new static($this->client);
        $model->fill($attributes);
        if (isset($this->webinarID)) {
            $model->setwebinarID($this->webinarID);
        }

        return $model;
    }
}
