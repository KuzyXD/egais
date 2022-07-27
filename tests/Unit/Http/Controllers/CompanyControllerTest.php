<?php

namespace Http\Controllers;

use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyControllerTest extends TestCase {
    use RefreshDatabase;

    public function testIndex() {

    }

    public function testStore() {
        Sanctum::actingAs(
                Manager::factory(['fio' => 'Илья Кузнецов'])->create(),
                ['*'],
                'manager'
        );

        $company = [
                'name' => 'ООО "ПНК"',
                'group' => 'ПНК'
        ];

        $this->post('api/manager/company/store', $company);
        $this->assertDatabaseHas('companies', $company);
    }

    public function testDestroy() {

    }

    public function testCreate() {

    }

    public function testUpdate() {

    }

    public function testShow() {

    }

    public function testEdit() {

    }
}
