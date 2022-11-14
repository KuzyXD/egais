<?php

namespace App\Enums;

use Spatie\Enum\Enum;


/**
 * @method static self PASSPORT()
 * @method static self PHOTO()
 * @method static self SNILS()
 * @method static self REQUEST()
 * @method static self APPLICATION()
 * @method static self PROCURATION()
 * @method static self ZIP()
 * @method static self SIGNED_ZIP()
 * @method static self CERTIFICATE_BLANK()
 * @method static self CERTIFICATE()
 */
class FileTypes extends Enum
{

    protected static function values(): array
    {
        return [
            'APPLICATION' => 1,
            'PROCURATION' => 2,
            'CERTIFICATE_BLANK' => 6,
            'CERTIFICATE' => 7,
            'ZIP' => 8,
            'SIGNED_ZIP' => 9,
            'REQUEST' => 0
        ];
    }
}
