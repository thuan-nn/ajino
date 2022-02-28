<?php

namespace Database\Factories;

use App\Enums\BannerType;
use App\Enums\LanguageEnum;
use App\Models\BannerTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BannerTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BannerTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'  => $this->faker->title,
            'locale' => Arr::random(LanguageEnum::asArray()),
        ];
    }
}
