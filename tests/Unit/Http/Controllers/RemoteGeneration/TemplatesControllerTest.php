<?php

namespace Http\Controllers\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TemplatesControllerTest extends TestCase
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
                RgApplicationsTemplate::factory(['created_by' => 1])->count(6),
                'applicationTemplates')->create();

        $response = $this->get('api/rg-manager/company/1/templates/?page=1');

        $response->assertJsonCount(6, 'data');
    }

    public function testStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->create(['id' => 1]);

        $templateData = [
            'type' => 3,
            'identificationKind' => 1,
            'BasisOfActs' => 'устава',
            'lastName' => 'Кузнецов',
            'firstName' => 'Илья',
            'middleName' => '',
            'applicant_fio' => 'Кузнецов Илья',
            'headLastName' => 'Коваль',
            'headFirstName' => 'Леонид',
            'headMiddleName' => 'Васильевич',
            'head_fio' => 'Коваль Леонид Васильевич',
            'HeadPosition' => 'Генеральный директор',
            'company' => 'ООО "ПНК"',
            'position' => 'Программист',
            'department' => 'Общее подразделение',
            'passportSerial' => '1234',
            'passportNumber' => '123456',
            'passportDate' => '30.06.2019',
            'passportCode' => '654321',
            'passportDivision' => 'ГУ МВД',
            'gender' => 'M',
            'birthDate' => '30.05.1999',
            'inn' => '1234567890',
            'personInn' => '123456789012',
            'ogrn' => '3210987654321',
            'kpp' => '123456789',
            'snils' => '12345678901',
            'email' => 'kuzyxd@yandex.ru',
            'phone' => '9058317811',
            'companyPhone' => '8117138509',
            'region' => 74,
            'city' => 'г Челябинск',
            'address' => 'Каплининская 19в, 73',
            'index' => '454094',
            'offerJoining' => true,
            'products' => '1234,32165',
        ];

        $this->post('api/rg-manager/company/1/templates/store', $templateData);

        $templateData['middleName'] = null;

        $this->assertDatabaseHas('rg_applications_templates', $templateData);
    }

    public function testUpdate()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        $templateData = [
            'type' => 3,
            'identificationKind' => 1,
            'BasisOfActs' => 'устава',
            'lastName' => 'Кузнецов',
            'firstName' => 'Илья',
            'middleName' => '',
            'applicant_fio' => 'Кузнецов Илья',
            'headLastName' => 'Коваль',
            'headFirstName' => 'Леонид',
            'headMiddleName' => 'Васильевич',
            'head_fio' => 'Коваль Леонид Васильевич',
            'HeadPosition' => 'Генеральный директор',
            'company' => 'ООО "ПНК"',
            'position' => 'Программист',
            'department' => 'Общее подразделение',
            'passportSerial' => '1234',
            'passportNumber' => '123456',
            'passportDate' => '30.06.2019',
            'passportCode' => '654321',
            'passportDivision' => 'ГУ МВД',
            'gender' => 'M',
            'birthDate' => '30.05.1999',
            'inn' => '1234567890',
            'personInn' => '123456789012',
            'ogrn' => '3210987654321',
            'kpp' => '123456789',
            'snils' => '12345678901',
            'email' => 'kuzyxd@yandex.ru',
            'phone' => '9058317811',
            'companyPhone' => '8117138509',
            'region' => 74,
            'city' => 'г Челябинск',
            'address' => 'Каплининская 19в, 73',
            'index' => '454094',
            'offerJoining' => true,
            'products' => '1234,32165',
        ];

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(
                RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1),
                'applicationTemplates')->create();

        $this->patch("api/rg-manager/company/templates/1/update", $templateData);

        $this->assertDatabaseHas('rg_applications_templates', ['company' => $templateData['company']]);
    }

    public function testShow()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(
                RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1),
                'applicationTemplates')->create();

        $this->get('api/rg-manager/company/templates/1/show')->assertJsonCount(42, 'data');
    }

    public function testDestroy()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory(['manager_id' => 1, 'id' => 1])
            ->has(RgApplicationsTemplate::factory(['created_by' => 1, 'id' => 1])->count(1),
                'applicationTemplates')->create();

        $this->delete("api/rg-manager/company/templates/1/delete");
        $this->assertSoftDeleted('rg_applications_templates', ['id' => 1]);
    }

    public function testUrStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->create(['id' => 1]);

        $templateData = [
            'type' => 3,
            'identificationKind' => 1,
            'BasisOfActs' => 'устава',
            'lastName' => 'Кузнецов',
            'firstName' => 'Илья',
            'middleName' => '',
            'applicant_fio' => 'Кузнецов Илья',
            'headLastName' => 'Коваль',
            'headFirstName' => 'Леонид',
            'headMiddleName' => 'Васильевич',
            'head_fio' => 'Коваль Леонид Васильевич',
            'HeadPosition' => 'Генеральный директор',
            'company' => 'ООО "ПНК"',
            'position' => 'Программист',
            'department' => 'Общее подразделение',
            'passportSerial' => '1234',
            'passportNumber' => '123456',
            'passportDate' => '30.06.2019',
            'passportCode' => '654321',
            'passportDivision' => 'ГУ МВД',
            'gender' => 'M',
            'birthDate' => '30.05.1999',
            'inn' => '1234567890',
            'personInn' => '123456789012',
            'ogrn' => '3210987654321',
            'kpp' => '123456789',
            'snils' => '12345678901',
            'email' => 'kuzyxd@yandex.ru',
            'phone' => '9058317811',
            'companyPhone' => '8117138509',
            'region' => 74,
            'city' => 'г Челябинск',
            'address' => 'Каплининская 19в, 73',
            'index' => '454094',
            'offerJoining' => true,
            'products' => '1234,32165',
        ];

        $this->post('api/rg-manager/company/1/templates/store', $templateData);

        $templateData['middleName'] = null;

        $this->assertDatabaseHas('rg_applications_templates', $templateData);
    }

    public function testIpStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->create(['id' => 1]);

        $templateData = [
            'type' => 2,
            'identificationKind' => 1,
            'lastName' => 'Кузнецов',
            'firstName' => 'Илья',
            'middleName' => '',
            'applicant_fio' => 'Кузнецов Илья',
            'passportSerial' => '1234',
            'passportNumber' => '123456',
            'passportDate' => '30.06.2019',
            'passportCode' => '654321',
            'passportDivision' => 'ГУ МВД',
            'gender' => 'M',
            'birthDate' => '30.05.1999',
            'inn' => '1234567890',
            'ogrn' => '321098765432112',
            'snils' => '12345678901',
            'email' => 'kuzyxd@yandex.ru',
            'phone' => '9058317811',
            'companyPhone' => '8117138509',
            'region' => 74,
            //'city' => 'г Челябинск',
            //'address' => 'Каплининская 19в, 73',
            'offerJoining' => true,
            'products' => '1234,32165',
        ];

        $this->post('api/rg-manager/company/1/templates/store', $templateData);

        $templateData['middleName'] = null;

        $this->assertDatabaseHas('rg_applications_templates', $templateData);
    }

    public function testPhysStore()
    {
        Sanctum::actingAs(
            RgManager::factory(['fio' => 'Илья Кузнецов', 'id' => 1])->create(),
            ['*'],
            'rg-manager'
        );

        RgCompany::factory()->create(['id' => 1]);

        $templateData = [
            'type' => 1,
            'identificationKind' => 1,
            'lastName' => 'Кузнецов',
            'firstName' => 'Илья',
            'middleName' => '',
            'applicant_fio' => 'Кузнецов Илья',
            'passportSerial' => '1234',
            'passportNumber' => '123456',
            'passportDate' => '30.06.2019',
            'passportCode' => '654321',
            'passportDivision' => 'ГУ МВД',
            'gender' => 'M',
            'birthDate' => '30.05.1999',
            'inn' => '1234567890',
            'snils' => '12345678901',
            'email' => 'kuzyxd@yandex.ru',
            'phone' => '9058317811',
            'region' => 74,
            'city' => 'г Челябинск',
            //'address' => 'Каплининская 19в, 73',
            'offerJoining' => true,
            'products' => '1234,32165',
        ];

        $this->post('api/rg-manager/company/1/templates/store', $templateData);

        $templateData['middleName'] = null;

        $this->assertDatabaseHas('rg_applications_templates', $templateData);
    }
}
