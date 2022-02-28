<?php

namespace Database\Factories;

use App\Models\JobTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->title,
            'description' => $this->faker->text,
            'salary'      => (object) [
                'from' => $this->faker->randomNumber(),
                'to'   => $this->faker->randomNumber(),
            ],
            'job_type'    => $this->faker->jobTitle,
            'is_feature'  => $this->faker->boolean,
        ];
    }
}
