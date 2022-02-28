<?php

namespace Database\Factories;

use App\Enums\PostTypeEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type'         => strtolower(array_rand(PostTypeEnum::asArray())),
            'is_published' => $this->faker->boolean,
            'order'        => $this->faker->unique()->numberBetween(1, 1000),
        ];
    }
}
