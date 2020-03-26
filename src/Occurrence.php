<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class Occurrence extends Model
{
    const KEY_FIELD = 'occurrence_id';

    protected $attributes = [
        'occurrence_id' => null, // integer
        'start_time' => null, // string [date-time]
        'duration' => null, // integer
        'status' => null, // string
    ];
}
