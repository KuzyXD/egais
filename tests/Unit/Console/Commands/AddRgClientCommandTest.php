<?php

namespace Tests\Unit\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddRgClientCommandTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testHandle()
    {
        $data = [
            'fio' => $this->faker->name(),
            'certificate_serial_number' => '01D880AD474855900000000C381D0002',
            'password' => '111',
        ];

        $this->artisan('rgclient:add', $data)->assertSuccessful();
    }
}
