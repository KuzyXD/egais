<?php

namespace Http\Controllers\RemoteGeneration;

use App\Http\Controllers\RemoteGeneration\ClientGroupController;
use App\Models\RemoteGeneration\RgClient;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use App\Services\RemoteGeneration\RgClientGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientGroupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'КБ']);
        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'Крым']);
        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'Вереск']);
        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'Мавт']);

        $response = $this->get('api/rg-manager/group/list');

        $response->assertJson([
            'Вереск',
            'КБ',
            'Крым',
            'Мавт',
        ]);
    }

    public function testShow()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'КБ']);
        RgClient::factory()->count(1)->create(['id' => 1, 'group' => 'КБ']);

        $this->get('api/rg-manager/group/1/show')->assertJson(['КБ']);
    }

    public function testUpdate()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'КБ']);
        RgCompany::factory()->count(2)->create(['manager_id' => 1, 'group' => 'Вереск']);
        RgClient::factory()->count(1)->create(['id' => 1, 'group' => 'КБ']);

        $data = [
            'group' => 'Вереск'
        ];

        $this->patch('api/rg-manager/group/1/update', $data);

        $data['id'] = 1;
        $this->assertDatabaseHas('rg_clients', $data);
    }
}
