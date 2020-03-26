<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

class WebinarSetting extends Model
{
    public $response;

    const KEY_FIELD = 'host_video';

    protected $attributes = [
        'host_video' => null, // boolean
        'panelists_video' => null, // boolean
        'practice_session' => null, // boolean
        'hd_video' => null, // boolean
        'approval_type' => null, // integer
        'registration_type' => null, // integer
        'audio' => null, // string
        'auto_recording' => null, // string
        'enforce_login' => null, // boolean
        'enforce_login_domains' => null, // string
        'alternative_hosts' => null, // string
        'close_registration' => null, // boolean
        'show_share_button' => null, // boolean
        'allow_multiple_devices' => null, // boolean
        'on_demand' => null, // boolean
        'global_dial_in_countries' => null, // string
        'contact_name' => null, // boolean
        'contact_email' => null, // boolean
        'registrants_confirmation_email' => null, //boolean
        'registrants_email_notification' => null, //boolean
    ];

    protected $createAttributes = [
        'host_video',
        'panelists_video',
        'practice_session',
        'hd_video',
        'approval_type',
        'registration_type',
        'audio',
        'auto_recording',
        'enforce_login',
        'enforce_login_domains',
        'alternative_hosts',
        'close_registration',
        'show_share_button',
        'allow_multiple_devices',
        'on_demand',
        'global_dial_in_countries',
        'contact_name',
        'contact_email',
    ];

    protected $updateAttributes = [
        'host_video',
        'panelists_video',
        'practice_session',
        'hd_video',
        'approval_type',
        'registration_type',
        'audio',
        'auto_recording',
        'enforce_login',
        'enforce_login_domains',
        'alternative_hosts',
        'close_registration',
        'show_share_button',
        'allow_multiple_devices',
        'on_demand',
        'global_dial_in_countries',
        'contact_name',
        'contact_email',
        'registrants_confirmation_email',
        'registrants_email_notification',
    ];
}
