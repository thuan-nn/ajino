<?php

namespace Database\Factories;

use App\Enums\LocationEnum;
use App\Enums\MajorEnum;
use App\Enums\VisitorStatusEnum;
use App\Models\CompanyTour;
use App\Models\Location;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class VisitorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Visitor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $companyTourIds = CompanyTour::query()->get()->pluck('id')->toArray();

        $locationNames = Location::query()->where('type', LocationEnum::JOB)->get()->pluck('id')->toArray();

        return [
            'company_tour_id' => Arr::random($companyTourIds),
            'name'            => $this->faker->name,
            'address'         => $this->faker->address,
            'email'           => $this->faker->email,
            'phone_number'    => '098876544',
            'amount_visitor'  => 100,
            'majors'          => Arr::random(MajorEnum::asArray()),
            'job_location'    => 'guni',
            'city'            => Arr::random($locationNames),
            'status'          => Arr::random(VisitorStatusEnum::asArray()),
        ];
    }
}
