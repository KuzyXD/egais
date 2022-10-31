<?php

namespace Database\Factories;

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
            'department' => $this->faker->word(),
            'passportSerial' => $this->faker->word(),
            'passportNumber' => $this->faker->word(),
            'passportDate' => $this->faker->word(),
            'passportCode' => $this->faker->word(),
            'passportDivision' => $this->faker->word(),
            'gender' => 'M',
            'birthDate' => $this->faker->date(),
            'inn' => $this->faker->numerify('############'),
            'personInn' => $this->faker->numerify('############'),
            'ogrn' => $this->faker->numerify('#############'),
            'kpp' => $this->faker->numerify('#########'),
            'snils' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'companyPhone' => $this->faker->numerify('##########'),
            'region' => $this->faker->randomNumber(),
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'index' => $this->faker->numerify('######'),
            'offerJoining' => $this->faker->boolean(),
            'products' => $this->faker->numerify('####,####'),
            'created_at' => Carbon::now(),
        ];
    }
}
