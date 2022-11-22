<?php

namespace Database\Seeders;

use App\Enums\Statuses;
use App\Models\RemoteGeneration\RgApplications;
use App\Models\RemoteGeneration\RgApplicationsTemplate;
use App\Models\RemoteGeneration\RgCompany;
use App\Models\RemoteGeneration\RgManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestFillSeeder extends Seeder
{
    public function run()
    {
        RgManager::factory()->create(['fio' => 'Илья Кузнецов', 'password' => Hash::make('111'), 'id' => 1, 'email' => 'kuzyxd@yandex.ru']);
        RgManager::factory()->create(['fio' => 'Людмила Сосненко', 'password' => Hash::make('111'), 'id' => 2, 'email' => 'kuzyxd1@yandex.ru']);
        RgCompany::factory()->count(1)->create(['group' => 'КБ', 'manager_id' => 1]);
        RgCompany::factory()->count(1)->create(['group' => 'Вереск', 'manager_id' => 2]);
        RgApplicationsTemplate::factory()->count(1)->create(["id" => 1,
            "created_by" => 1,
            "created_for" => 1,
            "type" => 3,
            "identificationKind" => 0,
            "BasisOfActs" => "доверенности",
            "firstName" => "Иван",
            "middleName" => "Андреевич",
            "lastName" => "Курбаков",
            "applicant_fio" => "Курбаков Иван Андреевич",
            "headLastName" => "Малыгин",
            "headFirstName" => "Вадим",
            "headMiddleName" => "Анатольевич",
            "head_fio" => "Малыгин Вадим Анатольевич",
            "HeadPosition" => "ДИРЕКТОР",
            "company" => "ООО \"ПОСЕЙДОН\"",
            "position" => "Представитель по доверенности",
            "department" => NULL,
            "passportSerial" => "7512",
            "passportNumber" => "092592",
            "passportDate" => "2012-06-09",
            "passportCode" => "740029",
            "passportDivision" => "ОТДЕЛЕНИЕМ №3 УФМС РОССИИ ПО ЧЕЛЯБИНСКОЙ ОБЛАСТИ В ЛЕНИНСКОМ РАЙОНЕ ГОР.МАГНИТОГОРСКА",
            "gender" => "M",
            "birthDate" => "1992-05-21",
            "inn" => "9200003904",
            "personInn" => "744410360591",
            "ogrn" => "1219200003175",
            "kpp" => "920001001",
            "snils" => "15811873074",
            "email" => "ep@eda-voda.ru",
            "phone" => "9789361486",
            "companyPhone" => "9789361486",
            "countryId" => 193,
            "region" => 91,
            "city" => "Г. СЕВАСТОПОЛЬ",
            "address" => "РУДНЕВА УЛ., Д. 30-А, ПОМЕЩ. 3",
            "index" => "299053",
            "offerJoining" => "true",
            "products" => "15103",
            "created_at" => "2022-11-22 11:12:30",
            "updated_at" => "2022-11-22 11:12:30",
            "deleted_at" => NULL
        ]);
        RgApplications::factory()->count(1)->create([
            "id" => 1,
            "created_by" => 1,
            "ac_id" => 1138353,
            "template_id" => 1,
            "pin_code" => NULL,
            "comment" => NULL,
            "action_type" => NULL,
            "store_number" => NULL,
            "status" => "SENDING_DOCUMENTS",
            "certificate_produced_at" => NULL,
            "serial_number_certificate" => NULL,
            "replace_serial_key" => NULL,
            "certificate_finished_at" => NULL,
            "ac_login" => "1884@krasnoe-beloe.ru",
            "ac_pass" => "eItwOrTf8b",
            "created_at" => "2022-11-22 11:55:40",
            "updated_at" => "2022-11-22 11:57:09",
            "deleted_at" => NULL
        ]);
    }
}
