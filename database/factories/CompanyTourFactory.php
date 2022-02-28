<?php

namespace Database\Factories;

use App\Enums\LocationEnum;
use App\Enums\TourType;
use App\Models\CompanyTour;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CompanyTourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyTour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locationIds = Location::query()
                               ->where('addditional->tour_page', '=', true)
                               ->where('type', LocationEnum::VISIT)->pluck('id')->toArray();

        return [
            'location_id' => Arr::random($locationIds),
            'date'        => $this->faker->date(),
            'type'        => Arr::random(TourType::asArray()),
        ];
    }
}
