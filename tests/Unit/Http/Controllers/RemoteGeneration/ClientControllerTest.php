<?php

namespace Http\Controllers\RemoteGeneration;

use App\Http\Controllers\RemoteGeneration\ClientController;
use App\Models\RemoteGeneration\RgClient;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $data = [
            'fio' => 'Заславский Дмитрий',
            'email' => 'test@yandex.ru',
            'password' => '111',
            'note' => 'тестовая сущность'
        ];

        $this->post('api/rg-manager/client/store', $data);
        
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
            'email' => 'test@yandex.ru',
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
            'email' => 'test@yandex.ru',
            'note' => 'тестовая сущность'
        ];
        RgClient::factory($parameters)->create();

        $this->patch('api/rg-manager/client/1/update', Arr::except($parameters, 'id'));

        $this->assertDatabaseHas('rg_clients', $parameters);
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
            'email' => 'test@yandex.ru',
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
            'email' => 'test@yandex.ru',
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
