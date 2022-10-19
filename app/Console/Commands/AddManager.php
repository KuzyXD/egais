<?php

namespace App\Console\Commands;

use App\Services\Auth\Manager;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class AddManager extends Command
{
    //TODO для RG добавить свои методы
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
