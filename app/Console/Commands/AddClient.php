<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use App\Services\Auth\Client;
use Illuminate\Console\Command;

class AddClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:add {fio} {certificate_serial_number} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавляет клиента для авторизации';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Client $clientService)
    {
        return boolval($clientService->create(Arr::except($this->arguments(), 'command')));
    }
}
