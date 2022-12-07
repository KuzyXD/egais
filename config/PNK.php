<?php

return [
    'ALLOWED_STATUSES_FOR_CLIENT_ACTION' => [
        \App\Enums\Statuses::REQUEST_GENERATION()->label, \App\Enums\Statuses::CERTIFICATE_READY()->label
    ],
    'SHA1_OF_SIGN_BY_AC' => env('SHA1_OF_SIGN_BY_AC'),
    'PINCODE_OF_SIGN_BY_AC' => env('PINCODE_OF_SIGN_BY_AC')
];
