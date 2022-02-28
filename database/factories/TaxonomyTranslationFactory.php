<?php

namespace Database\Factories;

use App\Enums\LanguageEnum;
use App\Models\TaxonomyTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxonomyTranslationFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TaxonomyTranslation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'title'  => $this->faker->unique()->text(10),
            'slug'   => $this->faker->unique()->slug,
        ];
    }
}
