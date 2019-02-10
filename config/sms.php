<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 2/5/2019
 * Time: 10:20 PM
 */

return [
    'default_sms_provider'=>env('SMS_PROVIDER', 'shoutout'),//dialog,shoutout,log
    'fallback_sms_provider'=>env('SMS_PROVIDER_FALLBACK', ''), //alternative sms provider for an emergency

    'shoutout'=>[
        'api_key'=>env('SHOUTOUT_API_KEY', 'XXXXXXXXX.XXXXXXXXX.XXXXXXXXX'),
        'from'=>env('SHOUTOUT_FROM_NUMBER', 'YOUR_NUMBER_MASK_HERE'),
    ],
    'dialog'=>[
        'username'=>env('DIALOG_USERNAME', ''),
        'password'=>env('DIALOG_PASSWORD', ''),
        'from'=>env('DIALOG_FROM_NUMBER', 'YOUR_NUMBER_MASK_HERE'),
    ],
];