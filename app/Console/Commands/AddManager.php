<?php

namespace App\Console\Commands;

use App\Services\Manager;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AddManager extends Command
{
    protected $signature = 'manager:add {fio} {email} {password} {tel}';

    protected $description = 'Добавляет сотрудника для авторизации';

    public function handle(Manager $managerService): bool
    {
        return $managerService->create(Arr::except($this->arguments(), 'command')) ? self::SUCCESS : self::FAILURE;
    }
}
