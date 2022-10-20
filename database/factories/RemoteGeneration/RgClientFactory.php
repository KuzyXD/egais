<?php

namespace Database\Factories\RemoteGeneration;

use App\Models\RemoteGeneration\RgClient;
use Illuminate\Database\Eloquent\Factories\Factory;

class RgClientFactory extends Factory
{
    protected $model = RgClient::class;

    public function definition(): array
    {
        return [
            'fio' => $this->faker->name(),
            'password' => '$2a$12$yloCK36BBLj7F5gxiMY.8OSLXhLHkv3Qt37D.FAZJjo7Z1Z.3FJRy', //111
        ];
    }
}
