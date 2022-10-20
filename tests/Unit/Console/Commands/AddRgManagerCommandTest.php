<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddRgManagerCommandTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testHandle()
    {
        $data = [
            'fio' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '111',
            'tel' => $this->faker->phoneNumber()
        ];

        $this->artisan('rgmanager:add', $data)->assertSuccessful();
    }
}
