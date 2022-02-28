<?php

namespace App\Transformers;

use App\Models\PostTranslation;
use Flugg\Responder\Transformers\Transformer;

class PostTranslationTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\PostTranslation $postTranslation
     *
     * @return array
     */
    public function transform(PostTranslation $postTranslation)
    {
        return [
            'id'          => (string) $postTranslation->id,
            'post_id'     => (string) $postTranslation->post_id,
            'title'       => (string) $postTranslation->title,
            'slug'        => (string) $postTranslation->slug,
            'description' => (string) $postTranslation->description,
            'locale'      => (string) $postTranslation->locale,
            'additional'  => (array) $postTranslation->additional,
            'thumbnail'   => thumbnail($postTranslation->files->pluck('id')->toArray()),
            'created_by'  => (string) $postTranslation->created_by,
            'updated_by'  => (string) $postTranslation->updated_by,
        ];
    }
}
