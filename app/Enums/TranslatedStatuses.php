<?php

namespace App\Enums;


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
class TranslatedStatuses extends Statuses
{
    protected static function values(): array
    {
        return [
            'UNKNOWN' => 'Статус неизвестен',
            'SYSTEM_PROCESSING' => 'В обработке',
            'IN_MODERATION' => 'На модерации',
            'SENDING_DOCUMENTS' => 'Отправка документов',
            'REQUEST_GENERATION' => 'Генерация запроса',
            'GENERATING_CERTIFICATE' => 'Выпуск',
            'CERTIFICATE_READY' => 'Сертификат выпущен',
            'DECLINED' => 'Отказ'
        ];
    }
}
