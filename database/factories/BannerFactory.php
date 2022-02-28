<?php

namespace Database\Factories;

use App\Enums\BannerSlideTypeEnum;
use App\Enums\PostTypeEnum;
use App\Models\Banner;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $postIds = Post::query()
                       ->where('type', PostTypeEnum::PAGE)
                       ->pluck('id')
                       ->toArray();

        return [
            'is_published' => $this->faker->boolean,
            'order'        => $this->faker->unique()->numberBetween(0, 100),
            'post_id'      => Arr::random($postIds),
            'type_slide'   => Arr::random(BannerSlideTypeEnum::asArray()),
        ];
    }
}
