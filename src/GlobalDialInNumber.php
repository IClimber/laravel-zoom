<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class GlobalDialInNumber extends Model
{
    public $response;

    const KEY_FIELD = 'country';

    protected $attributes = [
        'country' => null, // boolean
        'country_name' => null, // boolean
        'city' => null, // boolean
        'number' => null, // boolean
        'type' => null, // boolean
    ];

    protected $createAttributes = [

    ];

    protected $updateAttributes = [
        'country',
        'country_name',
        'city',
        'number',
        'type',
    ];
}
