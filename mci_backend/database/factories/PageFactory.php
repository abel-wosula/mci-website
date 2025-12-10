<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PageFactory extends Factory
{
    public function definition(): array
    {
       return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'featured_image' => $this->faker->imageUrl(),
            'is_published' => true,
        ];
    }
}
