<?php

namespace Database\Factories\RemoteGeneration;

use App\Enums\FileTypes;
use App\Models\RemoteGeneration\RgApplicationFiles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Enum\Faker\FakerEnumProvider;

class RgApplicationFilesFactory extends Factory
{

    protected $model = RgApplicationFiles::class;

    public function definition(): array
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));

        return [
            'name' => $this->faker->word() . '.' . $this->faker->fileExtension(),
            'type' => $this->faker->unique(true)->randomEnumLabel(FileTypes::class),
            'path' => $this->faker->filePath(),
            'sig_path' => $this->faker->filePath() . '.sig'
        ];
    }
}
