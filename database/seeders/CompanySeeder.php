<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder {
    public function run() {
        Company::factory(['group' => 'КБ', 'manager_id' => 1])->count(50)->create();
        Company::factory(['group' => 'Вереск', 'manager_id' => 1])->count(30)->create();
        Company::factory(['group' => 'Облпотребсоюз', 'manager_id' => 1])->count(20)->create();
    }
}
