<?php

namespace Database\Factories\RemoteGeneration;

use App\Enums\FileTypes;
use App\Models\RemoteGeneration\RgApplicationTemplateFiles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Enum\Faker\FakerEnumProvider;

class RgApplicationTemplateFilesFactory extends Factory
{
    use WithFaker;

    protected $model = RgApplicationTemplateFiles::class;

    public function definition(): array
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));
        return [
            'path' => $this->faker->filePath(),
            'name' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'type' => $this->faker->randomEnumLabel(FileTypes::class)
        ];
    }
}
