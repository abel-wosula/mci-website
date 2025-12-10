<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
   public function definition()
{
    return [
        'user_id' => User::factory(),
        'type' => $this->faker->randomElement(['image', 'video', 'infographic']),
        'path' => $this->faker->imageUrl(),
        'filename' => $this->faker->word() . '.' . $this->faker->fileExtension(),
        'size' => $this->faker->numberBetween(1000, 5000000), // size in bytes
        'original_name' => $this->faker->word() . '.' . $this->faker->fileExtension(),
        'mime_type' => $this->faker->mimeType(),
    ];
}
}
