<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class TrackingField extends Model
{
    public $response;

    const KEY_FIELD = 'field';

    protected $attributes = [
        'field' => '', // boolean
        'value' => '', // boolean
    ];

    protected $createAttributes = [
        'field',
        'value',
    ];

    protected $updateAttributes = [
        'field',
        'value',
    ];
}
