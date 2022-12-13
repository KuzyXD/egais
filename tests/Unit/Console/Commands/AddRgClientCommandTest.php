<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddRgClientCommandTest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    public function testHandle()
    {
        $data = [
            'fio' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => '111',
        ];

        $this->artisan('rgclient:add', $data)->assertSuccessful();
    }
}
