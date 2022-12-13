<?php

namespace App\Console\Commands;

use App\Services\RemoteGeneration\RgClient;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AddRgClientCommand extends Command
{
    protected $signature = 'rgclient:add {fio} {email} {password}';

    protected $description = 'Добавляет клиента в базу данных для доступа к удаленному перевыпуску';

    public function handle(RgClient $clientService): bool
    {
        return $clientService->create(Arr::except($this->arguments(), ['command', 0])) ? self::SUCCESS : self::FAILURE;
    }
}
