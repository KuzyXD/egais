<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use App\Services\Auth\Manager;
use Illuminate\Console\Command;

class AddManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manager:add {fio} {email} {password} {tel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавляет сотрудника для авторизации';

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
    public function handle(Manager $managerService)
    {
        return boolval($managerService->create(Arr::except($this->arguments(), 'command')));
    }
}
