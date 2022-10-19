<?php

namespace Database\Factories\RemoteGeneration;

use App\Models\RemoteGeneration\RgManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class RgManagerFactory extends Factory
{
    protected $model = RgManager::class;

    public function definition(): array
    {
        return [
            'fio' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make('111'),
            'tel' => $this->faker->phoneNumber()
        ];
    }
}
