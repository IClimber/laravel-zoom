<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class Occurrence extends Model
{
    const KEY_FIELD = 'occurrence_id';

    protected $attributes = [
        'occurrence_id' => '', // integer
        'start_time' => '', // string [date-time]
        'duration' => '', // integer
        'status' => '', // string
    ];
}
