<?php

namespace IClimber\Zoom;

use IClimber\Zoom\Support\Model;

/**
 * Class MeetingSetting
 * @package IClimber\Zoom
 *
 * @property boolean $host_video
 * @property boolean $participant_video
 * @property boolean $cn_meeting
 * @property boolean $in_meeting
 * @property boolean $join_before_host
 * @property boolean $mute_upon_entry
 * @property boolean $watermark
 * @property boolean $use_pmi
 * @property integer $approval_type
 * @property integer $registration_type
 * @property string $audio
 * @property string $auto_recording
 * @property boolean $enforce_login
 * @property string $enforce_login_domains
 * @property string $alternative_hosts
 * @property string $close_registration
 * @property string $waiting_room
 * @property string $contact_name
 * @property string $contact_email
 * @property-read boolean $registrants_confirmation_email
 * @property boolean $registrants_email_notification
 * @property array $global_dial_in_countries
 * @property array $global_dial_in_numbers
 */
class MeetingSetting extends Model
{
    public $response;

    const KEY_FIELD = 'host_video';

    protected $attributes = [
        'host_video' => null, // boolean
        'participant_video' => null, // boolean
        'cn_meeting' => null, // boolean
        'in_meeting' => null, // boolean
        'join_before_host' => null, // boolean
        'mute_upon_entry' => null, // boolean
        'watermark' => null, // boolean
        'use_pmi' => null, // boolean
        'approval_type' => null, // integer
        'registration_type' => null, // integer
        'audio' => null, // string
        'auto_recording' => null, // string
        'enforce_login' => null, // boolean
        'enforce_login_domains' => null, // string
        'alternative_hosts' => null, // string
        'close_registration' => null, // string
        'waiting_room' => null, // string
        'contact_name' => null, // string
        'contact_email' => null, // string
        'registrants_confirmation_email' => null, // boolean
        'registrants_email_notification' => null, // boolean
        'global_dial_in_countries' => [],
        'global_dial_in_numbers' => [],
    ];

    protected $createAttributes = [
        'host_video',
        'participant_video',
        'cn_meeting',
        'in_meeting',
        'join_before_host',
        'mute_upon_entry',
        'watermark',
        'use_pmi',
        'approval_type',
        'registration_type',
        'audio',
        'auto_recording',
        'enforce_login',
        'enforce_login_domains',
        'alternative_hosts',
        'close_registration',
        'waiting_room',
        'contact_name',
        'contact_email',
    ];

    protected $updateAttributes = [
        'host_video',
        'participant_video',
        'cn_meeting',
        'in_meeting',
        'join_before_host',
        'mute_upon_entry',
        'watermark',
        'use_pmi',
        'approval_type',
        'registration_type',
        'audio',
        'auto_recording',
        'enforce_login',
        'enforce_login_domains',
        'alternative_hosts',
        'close_registration',
        'waiting_room',
        'contact_name',
        'contact_email',
        'registrants_confirmation_email',
        'registrants_email_notification',
    ];

    protected $relationships = [
        'global_dial_in_numbers' => GlobalDialInNumber::class,
    ];

    public function addGlobalDialInNumbers(GlobalDialInNumber $number)
    {
        $this->global_dial_in_numbers[] = $number;
    }
}
