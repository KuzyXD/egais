<?php

namespace Http\Controllers\RemoteGeneration;

use App\Enums\FileTypes;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApplicationTemplateFilesControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

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

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1), 'applicationTemplates')->create();

        $this->post('api/rg-manager/company/templates/1/files/store', $data);

        $this->get('api/rg-manager/company/templates/files/1/show')->assertDownload('application.pdf');
    }

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

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1), 'applicationTemplates')->create();

        $this->post('api/rg-manager/company/templates/1/files/store', $data);

        $this->assertDatabaseHas('rg_application_template_files', ['name' => 'application.pdf']);
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1)
                ->has(RgApplicationTemplateFiles::factory(
                    [
                        'application_template_id' => 1,
                    ])->count(1), 'files'), 'applicationTemplates')->create();

        $this->delete('api/rg-manager/company/templates/files/1/delete');

        $this->assertSoftDeleted('rg_application_template_files', ['id' => 1, 'application_template_id' => 1]);
    }

    public function testIndex()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1)
                ->has(RgApplicationTemplateFiles::factory(
                    [
                        'application_template_id' => 1,
                    ])->count(3), 'files'), 'applicationTemplates')->create();

        $this->get('api/rg-manager/company/templates/1/files')->assertJsonCount(3);

    }

    protected function tearDown(): void
    {
        Storage::deleteDirectory('/templateFiles');
    }


}
