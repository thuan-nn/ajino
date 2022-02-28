<?php

namespace Database\Factories;

use App\Enums\VisitorStatusEnum;
use App\Models\CompanyTour;
use App\Models\MailHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class MailHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MailHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $companyTour = CompanyTour::query()->inRandomOrder()->first();
        $status = Arr::random(VisitorStatusEnum::getValues());

        return [
            'email'           => $this->faker->email,
            'status'          => $status,
            'company_tour_id' => $companyTour->id,
        ];
    }
}
