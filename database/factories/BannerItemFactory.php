<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\BannerItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BannerItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'banner_id' => Banner::query()->inRandomOrder()->first()->id,
            'order'     => $this->faker->unique()->numberBetween(0, 100),
        ];
    }
}
