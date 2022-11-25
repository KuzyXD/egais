<?php

namespace Http\Controllers\RemoteGeneration;

use App\Http\Controllers\RemoteGeneration\ClientController;
use App\Models\RemoteGeneration\RgClient;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $data = [
            'fio' => 'Заславский Дмитрий',
            'password' => '111',
            'certificate_serial_number' => '01d880ad474855900000000c381d0002',
            'certificate_expire_to_date' => '15.06.2022',
            'note' => 'тестовая сущность'
        ];

        $this->post('api/rg-manager/client/store', $data);

        $data['certificate_expire_to_date'] = Date::createFromFormat('d.m.Y', $data['certificate_expire_to_date']);

        $this->assertDatabaseHas('rg_clients', Arr::except($data, 'password'));
    }

    public function testShow()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $parameters = [
            'id' => 1,
            'certificate_serial_number' => '01d880ad474855900000000c381d0002',
            'certificate_expire_to_date' => Date::createFromDate('2022', '6', '15'),
            'note' => 'тестовая сущность'
        ];
        RgClient::factory($parameters)->create();

        $this->get('api/rg-manager/client/1/show')->assertJson(['data' => $parameters]);
    }

    public function testUpdate()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $parameters = [
            'id' => 1,
            'fio' => 'Дмитрий Тестович',
            'certificate_serial_number' => '01d880ad474855900000000c381d0002',
            'certificate_expire_to_date' => Date::createFromDate('2022', '6', '15'),
            'note' => 'тестовая сущность'
        ];
        RgClient::factory($parameters)->create();

        $requestParameters = $parameters;
        $requestParameters['certificate_serial_number'] = '01d880ad474855900043000c381d0002'; //изменили серийный номер
        $requestParameters['certificate_expire_to_date'] = '15.06.2022'; //изменил на строку для запроса

        $this->patch('api/rg-manager/client/1/update', Arr::except($requestParameters, 'id'));

        $dataForVerificate = $parameters;
        $dataForVerificate['certificate_serial_number'] = '01d880ad474855900043000c381d0002';
        $this->assertDatabaseHas('rg_clients', $dataForVerificate);
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $parameters = [
            'id' => 1,
            'certificate_serial_number' => '01d880ad474855900000000c381d0002',
            'certificate_expire_to_date' => Date::createFromDate('2022', '6', '15'),
            'note' => 'тестовая сущность'
        ];
        RgClient::factory($parameters)->create();

        $this->delete('api/rg-manager/client/1/delete');
        $this->assertSoftDeleted('rg_clients', $parameters);
    }

    public function testRecovery()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $parameters = [
            'id' => 1,
            'certificate_serial_number' => '01d880ad474855900000000c381d0002',
            'certificate_expire_to_date' => Date::createFromDate('2022', '6', '15'),
            'note' => 'тестовая сущность',
            'deleted_at' => Date::now()
        ];
        RgClient::factory($parameters)->create();

        $this->delete('api/rg-manager/client/1/delete');
        $this->assertNotSoftDeleted('rg_clients', Arr::except($parameters, 'deleted_at'));
    }

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgClient::factory()->count(10)->create();

        $response = $this->get('api/rg-manager/client/index?page=1');

        $this->assertEquals(10, $response->json('meta.total'));
    }
}
