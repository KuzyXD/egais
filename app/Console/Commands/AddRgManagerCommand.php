<?php

namespace App\Console\Commands;

use App\Services\RemoteGeneration\RgManager;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AddRgManagerCommand extends Command
{
    protected $signature = 'rgmanager:add {fio} {email} {password} {tel}';

    protected $description = 'Добавляет менеджера в базу данных для доступа к удаленному перевыпуску';

    public function handle(RgManager $managerService): bool
    {
        return $managerService->create(Arr::except($this->arguments(), 'command')) ? self::SUCCESS : self::FAILURE;
    }
}
