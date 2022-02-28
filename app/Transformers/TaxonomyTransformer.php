<?php

namespace App\Transformers;

use App\Models\Taxonomy;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;

class TaxonomyTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'posts' => PostTransformer::class,
        'jobs'  => JobTransformer::class,
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * @param Taxonomy $taxonomy
     *
     * @return array
     */
    public function transform(Taxonomy $taxonomy)
    {
        $thumbnails = $this->checkTranslateRelations($taxonomy, $this->locale);

        return [
            'id'           => (string) $taxonomy->id,
            'type'         => (string) $taxonomy->type,
            'page'         => (string) $taxonomy->page,
            'is_published' => (int) $taxonomy->is_published,
            'title'        => (string) $taxonomy->title,
            'slug'         => (string) $taxonomy->slug,
            'locale'       => (string) $taxonomy->locale,
            'additional'   => $taxonomy->additional,
            'images'       => $thumbnails ? thumbnail($thumbnails->files()->pluck('id')) : [],
            'language'     => (array) $taxonomy->language,
            'order'        => (int) $taxonomy->order,
            'created_by'   => (string) $taxonomy->created_by,
            'updated_at'   => (string) $taxonomy->updated_at,
        ];
    }
}
