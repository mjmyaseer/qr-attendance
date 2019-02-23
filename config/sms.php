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
        'api_key'=>env('SHOUTOUT_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI2NWMxYTczMC0yZjUwLTExZTktYjI2NS1lOWRiMTM0MWI2OTUiLCJzdWIiOiJTSE9VVE9VVF9BUElfVVNFUiIsImlhdCI6MTU1MDAzNTc5NiwiZXhwIjoxODY1NjU0OTk2LCJzY29wZXMiOnsiYWN0aXZpdGllcyI6WyJyZWFkIiwid3JpdGUiXSwibWVzc2FnZXMiOlsicmVhZCIsIndyaXRlIl0sImNvbnRhY3RzIjpbInJlYWQiLCJ3cml0ZSJdfSwic29fdXNlcl9pZCI6IjI3MDgiLCJzb191c2VyX3JvbGUiOiJ1c2VyIiwic29fcHJvZmlsZSI6ImFsbCIsInNvX3VzZXJfbmFtZSI6IiIsInNvX2FwaWtleSI6Im5vbmUifQ.hQlPbRlTMCaA9uOm9orwVmZR6GLTgNjIPTGqWrKrW-A

'),
        'from'=>env('SHOUTOUT_FROM_NUMBER', 'SLJI'),
    ],
    'dialog'=>[
        'username'=>env('DIALOG_USERNAME', ''),
        'password'=>env('DIALOG_PASSWORD', ''),
        'from'=>env('DIALOG_FROM_NUMBER', 'YOUR_NUMBER_MASK_HERE'),
    ],
];