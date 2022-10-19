<?php

namespace Database\Factories\RemoteGeneration;

use App\Models\RemoteGeneration\RgCompany;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RgCompanyFactory extends Factory
{
    protected $model = RgCompany::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'group' => $this->faker->word(),
            'manager_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
