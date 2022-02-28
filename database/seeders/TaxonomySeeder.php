<?php

namespace Database\Seeders;

use App\Enums\LanguageEnum;
use App\Models\Taxonomy;
use App\Models\TaxonomyTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaxonomySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Taxonomy::factory()->count(20)->create();
        $taxonomies = Taxonomy::query();
        $taxonomies->eachById(function ($taxonomy) {
            foreach (LanguageEnum::asArray() as $lang) {
                $taxonomyTranslation = TaxonomyTranslation::factory()->make(['taxonomy_id' => $taxonomy->id]);
                $taxonomyTranslation->locale = strtolower($lang);
                $taxonomyTranslation->save();
            }
        });
    }
}
