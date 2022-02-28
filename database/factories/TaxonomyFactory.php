<?php

namespace Database\Factories;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxonomyFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taxonomy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $type = strtolower(array_rand(TaxonomyEnum::asArray()));
        return [
            'type'         => $type,
            'page'         => $type === TaxonomyEnum::CATEGORY ? strtolower(array_rand(PostTypeEnum::asArray())) : null,
            'is_published' => $this->faker->boolean
        ];
    }
}
