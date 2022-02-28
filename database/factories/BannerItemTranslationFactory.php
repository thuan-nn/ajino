<?php

namespace Database\Factories;

use App\Enums\BannerType;
use App\Enums\LanguageEnum;
use App\Models\BannerItem;
use App\Models\BannerItemTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BannerItemTranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BannerItemTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'          => $this->faker->title,
            'description'    => $this->faker->text,
            'banner_item_id' => BannerItem::query()->inRandomOrder()->first()->id,
            'locale'         => Arr::random(LanguageEnum::asArray()),
            'type'           => Arr::random(BannerType::asArray()),
        ];
    }
}
