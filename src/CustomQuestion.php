<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class CustomQuestion extends Model
{
    const KEY_FIELD = 'title';

    protected $methods = [];

    protected $attributes = [
        'title' => null, // string
        'value' => null, // string
    ];

    protected $createAttributes = [
        'title',
        'value',
    ];

    protected $updateAttributes = [
        'title',
        'value',
    ];
}
