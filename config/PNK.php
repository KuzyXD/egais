<?php

return [
    'ALLOWED_STATUSES_FOR_CLIENT_ACTION' => [
        \App\Enums\Statuses::REQUEST_GENERATION()->label, \App\Enums\Statuses::CERTIFICATE_READY()->label
    ]
];
