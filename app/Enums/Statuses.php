<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self UNKNOWN()
 * @method static self CREATED()
 * @method static self SYSTEM_PROCESSING()
 * @method static self IN_MODERATION()
 * @method static self SENDING_DOCUMENTS()
 * @method static self REQUEST_GENERATION()
 * @method static self GENERATING_CERTIFICATE()
 * @method static self CERTIFICATE_READY()
 * @method static self DECLINED()
 */
class Statuses extends Enum
{
    protected static function values(): array
    {
        return [
            'UNKNOWN' => 0,
            'SYSTEM_PROCESSING' => 22,
            'IN_MODERATION' => 21,
            'SENDING_DOCUMENTS' => 1,
            'REQUEST_GENERATION' => 2,
            'GENERATING_CERTIFICATE' => 3,
            'CERTIFICATE_READY' => 4,
            'DECLINED' => 5
        ];
    }
}
