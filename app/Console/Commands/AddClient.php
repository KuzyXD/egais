<?php

namespace App\Console\Commands;

use App\Services\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AddClient extends Command
{
    protected $signature = 'client:add {fio} {certificate_serial_number} {password}';

    protected $description = 'Добавляет клиента для авторизации';

    public function handle(Client $clientService)
    {
        return $clientService->create(Arr::except($this->arguments(), 'command')) ? self::SUCCESS : self::FAILURE;
    }
}
