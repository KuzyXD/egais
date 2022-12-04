<?php

namespace Http\Controllers\RemoteGeneration;

use App\Enums\FileTypes;
use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplicationFiles;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApplicationFilesControllerTest extends TestCase
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
            'file' => UploadedFile::fake()->createWithContent('application.pdf', 'asasd2efsdfdgdfds'),
            'type' => FileTypes::APPLICATION()->label
        ];

        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['id' => 1, 'created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(1)->create();

        $this->post('api/rg-manager/application/1/files/store', $data);

        $this->assertDatabaseHas('rg_application_files', ['name' => 'application.pdf']);
    }

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['id' => 1, 'created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(1)->create();


        RgApplicationFiles::factory(['application_id' => 1])->count(3)->create();

        $this->get('api/rg-manager/application/1/files/index')->assertJsonCount(3);
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


        RgApplicationFiles::factory(['application_id' => 1])->count(1)->create();

        $this->delete('api/rg-manager/application/1/files/1/delete');

        $this->assertSoftDeleted('rg_application_files', ['id' => 1]);
    }

    public function testShow()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $data = [
            'file' => UploadedFile::fake()->createWithContent('application.pdf', 'asasd2efsdfdgdfds'),
            'type' => FileTypes::APPLICATION()->label
        ];

        $company = RgCompany::factory(['manager_id' => 1, 'id' => 1])->create();
        $template = RgApplicationsTemplate::factory(['id' => 1, 'created_by' => 1, 'created_for' => 1])->for($company, 'company')->create();
        $application = RgApplications::factory(['id' => 1, 'created_by' => 1, 'template_id' => 1, 'status' => Statuses::CREATED()->label])->count(1)->create();


        $this->post('api/rg-manager/application/1/files/store', $data);
        $this->get('api/rg-manager/application/1/files/1/show')->assertDownload('application.pdf');
    }

    public function testGetTemplateFiles()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $rgCompany = RgCompany::factory(['manager_id' => 1])->create();
        $applicationTemplate = RgApplicationsTemplate::factory(['created_by' => 1, 'created_for' => 1, 'id' => 1])->for($rgCompany, 'company')->create();
        $fileTemplate1 = RgApplicationTemplateFiles::factory(['type' => FileTypes::PASSPORT()->label])->for($applicationTemplate, 'applicationTemplate')->create();
        $fileTemplate2 = RgApplicationTemplateFiles::factory(['type' => FileTypes::PHOTO()->label])->for($applicationTemplate, 'applicationTemplate')->create();
        $fileTemplate3 = RgApplicationTemplateFiles::factory(['type' => FileTypes::SNILS()->label])->for($applicationTemplate, 'applicationTemplate')->create();
        RgApplications::factory(['status' => Statuses::CREATED()->label, 'created_by' => 1, 'template_id' => 1])->create();

        $this->get('api/rg-manager/application/1/files/template/getfiles');

        $this->assertDatabaseHas('rg_application_files', $fileTemplate1->only(['type', 'name', 'path']));
        $this->assertDatabaseHas('rg_application_files', $fileTemplate2->only(['type', 'name', 'path']));
        $this->assertDatabaseHas('rg_application_files', $fileTemplate3->only(['type', 'name', 'path']));
    }

    protected function tearDown(): void
    {
        Storage::deleteDirectory('/files');
    }

}
