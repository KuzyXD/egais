<?php

namespace Http\Controllers\RemoteGeneration;

use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(
                RgApplicationsTemplate::factory(['created_by' => 1])->count(6)->has(
                    RgApplications::factory(['created_by' => 1, 'status' => Statuses::CREATED()->label])->count(2), 'applications'
                ),
                'applicationTemplates')->create();


        $response = $this->get('api/rg-manager/application/index/?page=1');

        $response->assertJsonCount(6);
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(
                RgApplicationsTemplate::factory(['created_by' => 1])->count(1)->has(
                    RgApplications::factory(['id' => 1, 'created_by' => 1, 'status' => Statuses::CREATED()->label])->count(1), 'applications'
                ),
                'applicationTemplates')->create();

        $this->delete('api/rg-manager/application/1/delete/');

        $this->assertSoftDeleted('rg_applications', ['id' => 1]);
    }
}
