<?php

namespace Database\Seeders;

use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestFillSeeder extends Seeder
{
    public function run()
    {
        RgManager::factory()->create(['fio' => 'Илья Кузнецов', 'password' => Hash::make('111'), 'id' => 1, 'email' => 'kuzyxd@yandex.ru']);
        RgManager::factory()->create(['fio' => 'Людмила Сосненко', 'password' => Hash::make('111'), 'id' => 2, 'email' => 'kuzyxd1@yandex.ru']);
        RgCompany::factory()->count(1)->create(['group' => 'КБ', 'manager_id' => 1]);
        RgCompany::factory()->count(1)->create(['group' => 'Вереск', 'manager_id' => 2]);
        RgApplicationsTemplate::factory()->count(1)->create(['created_by' => 1, 'created_for' => 1]);
    }
}
