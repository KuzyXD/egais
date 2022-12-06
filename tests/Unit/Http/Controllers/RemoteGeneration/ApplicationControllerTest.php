<?php

namespace Http\Controllers\RemoteGeneration;

use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgClient;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(6)->create();


        $this->get('api/rg-manager/application/index/?page=1')->assertJsonCount(6, 'data');
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['id' => 1, 'created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(1)->create();


        $this->delete('api/rg-manager/application/1/delete/');

        $this->assertSoftDeleted('rg_applications', ['id' => 1]);
    }

    public function testIndexApplicationsByCompany()
    {
        Sanctum::actingAs(
            RgClient::factory(['fio' => 'Илья Кузнецов', 'id' => 1, 'group' => 'КБ'])->create(),
            ['*'],
            'rg-client'
        );

        RgManager::factory(['fio' => 'Шагалеев Максим', 'id' => 1])->create();
        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(3)->create();


        $this->get('api/rg-client/company/1/application/list')->assertJsonCount(3);
    }

    public function testGetSignedRoute()
    {
        Sanctum::actingAs(
            RgClient::factory(['fio' => 'Илья Кузнецов', 'id' => 1, 'group' => 'КБ'])->create(),
            ['*'],
            'rg-client'
        );

        RgManager::factory(['fio' => 'Шагалеев Максим', 'id' => 1])->create();
        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(3)->create();

        $this->get('api/rg-client/application/1/getsignedroute')->assertRedirectToSignedRoute();
    }

    public function testGetDn()
    {
        Sanctum::actingAs(
            RgClient::factory(['fio' => 'Илья Кузнецов', 'id' => 1, 'group' => 'КБ'])->create(),
            ['*'],
            'rg-client'
        );

        RgManager::factory(['fio' => 'Шагалеев Максим', 'id' => 1])->create();
        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(3)->create();

        $this->get('api/rg-client/application/1/dn')->assertJsonCount(15, 'data.dn');
    }
}
