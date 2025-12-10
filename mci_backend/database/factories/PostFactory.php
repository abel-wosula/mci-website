<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'featured_image' => $this->faker->imageUrl(),
            'content' => $this->faker->paragraphs(4, true),
            'status' => 'published',
        ];
    }
}
