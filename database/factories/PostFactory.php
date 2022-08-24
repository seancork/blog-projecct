<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1,50),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->sentence(20),
            'publication_date' => $this->faker->dateTimeBetween('+1 days', '+1 week')
        ];
    }
}
