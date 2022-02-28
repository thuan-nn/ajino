<?php

namespace Database\Factories;

use App\Models\PostTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->text(10),
            'slug'        => $this->faker->unique()->slug,
            'description' => $this->faker->text(50),
        ];
    }
}
