<?php

namespace Http\Controllers;

use App\Models\Company;
use App\Models\Manager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyControllerTest extends TestCase {
    use RefreshDatabase;

    public function testIndex() {
        Sanctum::actingAs(
                Manager::factory(['fio' => 'Илья Кузнецов'])->create(),
                ['*'],
                'manager'
        );

        Company::factory()->count(50)->create();

        $response = $this->get('api/manager/company/list');

        $this->assertTrue(count($response->json('data'))==10);
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
        Sanctum::actingAs(
                Manager::factory(['fio' => 'Илья Кузнецов'])->create(),
                ['*'],
                'manager'
        );

        $existedCompany = Company::factory(['manager_id' => 1])->create();
        $existedCompanyId = $existedCompany->id;

        $this->delete("api/manager/company/{$existedCompanyId}/delete");
        $this->assertDatabaseMissing('companies', $existedCompany->toArray());
    }

    public function testUpdate() {
        Sanctum::actingAs(
                Manager::factory(['fio' => 'Илья Кузнецов'])->create(),
                ['*'],
                'manager'
        );

        $newManager = Manager::factory(['fio' => 'Шагалеев Максим'])->create();
        $existedCompany = Company::factory(['manager_id' => 1])->create();
        $existedCompanyId = $existedCompany->id;

        $data = [
                'name' => 'ООО "ПНК-МАГНИТОГОРСК"',
                'group' => 'Магнитогорск',
                'manager_id' => $newManager->id
        ];

        $this->patch("api/manager/company/{$existedCompanyId}/update", $data);
        $this->assertDatabaseHas('companies', $data);
    }
}
