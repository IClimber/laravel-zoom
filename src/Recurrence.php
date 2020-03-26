<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class Recurrence extends Model
{
    const KEY_FIELD = 'type';

    protected $attributes = [
        'type' => null, // integer
        'repeat_interval' => null, // integer
        'weekly_days' => null, // integer
        'monthly_day' => null, // integer
        'monthly_week' => null, // integer
        'monthly_week_day' => null, // integer
        'end_times' => null, // integer
        'end_date_time' => null, // string [date-time]
    ];

    protected $createAttributes = [
        'type',
        'repeat_interval',
        'weekly_days',
        'monthly_day',
        'monthly_week',
        'monthly_week_day',
        'end_times',
        'end_date_time',
    ];

    protected $updateAttributes = [
        'type',
        'repeat_interval',
        'weekly_days',
        'monthly_day',
        'monthly_week',
        'monthly_week_day',
        'end_times',
        'end_date_time',
    ];
}
