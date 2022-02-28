<?php

namespace App\Transformers;

use App\Models\TaxonomyTranslation;
use Flugg\Responder\Transformers\Transformer;

class TaxonomyTranslationTranformer extends Transformer {
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'files' => FileTransformer::class
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param TaxonomyTranslation $taxonomyTranslation
     *
     * @return array
     */
    public function transform(TaxonomyTranslation $taxonomyTranslation) {
        return [
            'id'          => (string)$taxonomyTranslation->id,
            'taxonomy_id' => (string)$taxonomyTranslation->taxonomy_id,
            'title'       => (string)$taxonomyTranslation->title,
            'slug'        => (string)$taxonomyTranslation->slug,
            'thumbnails'  => thumbnail($taxonomyTranslation->files()->pluck('id')),
            'locale'      => (string)$taxonomyTranslation->locale,
            'additional'  => $taxonomyTranslation->additional,
        ];
    }
}
