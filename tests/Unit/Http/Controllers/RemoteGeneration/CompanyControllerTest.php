<?php

namespace Http\Controllers\RemoteGeneration;

use App\Models\RemoteGeneration\RgClient;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->count(10)->create(['manager_id' => 1]);

        $response = $this->get('api/rg-manager/company/list?page=1');

        $this->assertEquals(10, $response->json('total'));
    }

    public function testIndexWithSort()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->count(10)->create(['manager_id' => 1]);

        $response = $this->get('api/rg-manager/company/list?page=1&sort=id,desc&deleted=false&owned=false');

        $this->assertGreaterThan(9, $response->json('data')[0]['id']);
    }

    public function testStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $company = [
            'name' => 'ООО "ПНК"',
            'group' => 'ПНК'
        ];

        $this->post('api/rg-manager/company/store', $company);
        $this->assertDatabaseHas('rg_companies', $company);
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $existedCompany = RgCompany::factory(['manager_id' => 1])->create();
        $existedCompanyId = $existedCompany->id;

        $this->delete("api/rg-manager/company/$existedCompanyId/delete");
        $this->assertDatabaseMissing('rg_companies', $existedCompany->toArray());
    }

    public function testUpdate()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $newManager = RgManager::factory(['fio' => 'Шагалеев Максим', 'id' => 2])->create();
        $existedCompany = RgCompany::factory(['manager_id' => 1])->create();
        $existedCompanyId = $existedCompany->id;

        $data = [
            'name' => 'ООО "ПНК-МАГНИТОГОРСК"',
            'group' => 'Магнитогорск',
            'manager_id' => $newManager->id
        ];

        $this->patch("api/rg-manager/company/$existedCompanyId/update", $data);
        $this->assertDatabaseHas('rg_companies', $data);
    }

    public function testIndexCompanyByClientGroup()
    {
        Sanctum::actingAs(
            RgClient::factory(['fio' => 'Илья Кузнецов', 'id' => 1, 'group' => 'КБ'])->create(),
            ['*'],
            'rg-client'
        );

        RgManager::factory(['fio' => 'Шагалеев Максим', 'id' => 1])->create();
        RgCompany::factory()->count(10)->create(['manager_id' => 1, 'group' => 'КБ']);

        $this->get('api/rg-client/company/list')->assertJsonCount(10);
    }
}
