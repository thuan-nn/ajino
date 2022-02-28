<?php

namespace Database\Factories;

use App\Models\Menulink;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuLinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menulink::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $positions = range(1, 8);

        return [
            'position'     => array_values($positions)[array_rand(array_values($positions))],
            'is_published' => $this->faker->boolean,
        ];
    }
}
