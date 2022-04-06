<?php

namespace Database\Factories;

use App\Models\Thumbnail;
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
            'title' => $this->faker->word(),
            'content' => $this->faker->text(300),
            'tags' => $this->faker->words(3, true),
            'thumbnail_id' => Thumbnail::factory()->create()->id,
            'user_id' => $this->faker->numberBetween(1, 2)
        ];
    }
}
