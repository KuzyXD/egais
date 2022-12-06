<?php

namespace Database\Factories\RemoteGeneration;

use App\Models\RemoteGeneration\RgApplicationsTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RgApplicationsTemplateFactory extends Factory
{
    protected $model = RgApplicationsTemplate::class;

    public function definition(): array
    {
        return [
            'created_by' => $this->faker->randomNumber(),
            'type' => 3,
            'identificationKind' => 1,
            'BasisOfActs' => 'устава',
            'firstName' => $this->faker->firstName(),
            'middleName' => $this->faker->name(),
            'lastName' => $this->faker->lastName(),
            'applicant_fio' => $this->faker->word(),
            'headLastName' => $this->faker->lastName(),
            'headFirstName' => $this->faker->firstName(),
            'headMiddleName' => $this->faker->name(),
            'head_fio' => $this->faker->word(),
            'HeadPosition' => $this->faker->word(),
            'company' => $this->faker->company(),
            'position' => $this->faker->word(),
            'passportSerial' => $this->faker->numerify('####'),
            'passportNumber' => $this->faker->numerify('######'),
            'passportDate' => $this->faker->date('d-m-Y'),
            'passportCode' => $this->faker->numerify('######'),
            'passportDivision' => $this->faker->word(),
            'gender' => 'M',
            'birthDate' => $this->faker->date(),
            'inn' => $this->faker->numerify('##########'),
            'personInn' => $this->faker->numerify('############'),
            'ogrn' => $this->faker->numerify('#############'),
            'kpp' => $this->faker->numerify('#########'),
            'snils' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'companyPhone' => $this->faker->numerify('##########'),
            'region' => $this->faker->randomDigit(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'index' => $this->faker->numerify('######'),
            'offerJoining' => $this->faker->boolean(),
            'products' => $this->faker->numerify('####,####'),
            'created_at' => Carbon::now(),
        ];
    }

    public function ip(): array
    {
        return [
            'created_by' => $this->faker->randomNumber(),
            'type' => 2,
            'identificationKind' => 1,
            'firstName' => $this->faker->firstName(),
            'middleName' => $this->faker->name(),
            'lastName' => $this->faker->lastName(),
            'applicant_fio' => $this->faker->word(),
            'passportSerial' => $this->faker->numerify('####'),
            'passportNumber' => $this->faker->numerify('######'),
            'passportDate' => $this->faker->date('d-m-Y'),
            'passportCode' => $this->faker->numerify('######'),
            'passportDivision' => $this->faker->word(),
            'gender' => 'M',
            'birthDate' => $this->faker->date(),
            'inn' => $this->faker->numerify('##########'),
            'ogrn' => $this->faker->numerify('###############'),
            'snils' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'companyPhone' => $this->faker->numerify('##########'),
            'region' => $this->faker->randomDigit(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'offerJoining' => $this->faker->boolean(),
            'products' => $this->faker->numerify('####,####'),
            'created_at' => Carbon::now(),
        ];
    }

    public function phys(): array
    {
        return [
            'created_by' => $this->faker->randomNumber(),
            'type' => 1,
            'identificationKind' => 1,
            'firstName' => $this->faker->firstName(),
            'middleName' => $this->faker->name(),
            'lastName' => $this->faker->lastName(),
            'applicant_fio' => $this->faker->word(),
            'passportSerial' => $this->faker->numerify('####'),
            'passportNumber' => $this->faker->numerify('######'),
            'passportDate' => $this->faker->date('d-m-Y'),
            'passportCode' => $this->faker->numerify('######'),
            'passportDivision' => $this->faker->word(),
            'gender' => 'M',
            'birthDate' => $this->faker->date(),
            'inn' => $this->faker->numerify('##########'),
            'snils' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'companyPhone' => $this->faker->numerify('##########'),
            'region' => $this->faker->randomDigit(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'offerJoining' => $this->faker->boolean(),
            'products' => $this->faker->numerify('####,####'),
            'created_at' => Carbon::now(),
        ];
    }
}
