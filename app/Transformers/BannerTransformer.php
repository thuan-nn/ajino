<?php

namespace App\Transformers;

use App\Models\Banner;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;

class BannerTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'post' => PostTransformer::class,
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
     * @param \App\Models\Banner $banner
     * @return array
     */
    public function transform(Banner $banner)
    {
        return [
            'id'           => (string) $banner->id,
            'post_id'      => (string) $banner->post_id,
            'is_published' => (boolean) $banner->is_published,
            'type_slide'   => (string) $banner->type_slide,
            'order'        => (int) $banner->order,
            'title'        => (string) $banner->title,
            'locale'       => (string) $banner->locale,
            'language'     => (array) $banner->language,
            'additional'   => $banner->{'additional:'.$this->locale},
            'created_at'   => (string) $banner->created_at,
            'updated_at'   => (string) $banner->updated_at,
            'deleted_at'   => (string) $banner->deleted_at,
        ];
    }
}
