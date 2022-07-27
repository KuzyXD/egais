<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ManagerFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
                'fio' => $this->faker->name(),
                'email' => $this->faker->email(),
                'password' => Hash::make('111'),
                'tel' => $this->faker->phoneNumber()
        ];
    }
}
