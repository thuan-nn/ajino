<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locationIds = Location::all()->pluck('id')->toArray();

        return [
            'is_published' => $this->faker->boolean,
            'location_id'  => $locationIds[array_rand($locationIds)],
        ];
    }
}
