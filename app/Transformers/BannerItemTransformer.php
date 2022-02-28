<?php

namespace App\Transformers;

use App\Enums\BannerType;
use App\Models\BannerItem;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;

class BannerItemTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'banner' => BannerTransformer::class,
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
     * @param \App\Models\BannerItem $bannerItem
     * @return array
     */
    public function transform(BannerItem $bannerItem)
    {
        $translation = $this->checkTranslateRelations($bannerItem, $this->locale);

        return [
            'id'          => $bannerItem->id,
            'banner_id'   => $bannerItem->banner_id,
            'title'       => (string) $bannerItem->title,
            'url'         => (string) $bannerItem->url,
            'description' => (string) $bannerItem->description,
            'type'        => $bannerItem->type ?: BannerType::IMAGE,
            'video_url'   => (string) $bannerItem->video_url,
            'locale'      => $bannerItem->locale,
            'language'    => (array) $bannerItem->language,
            'order'       => (integer) $bannerItem->order,
            'images'      => $translation ? thumbnail($translation->files()->pluck('id')) : [],
            'created_at'  => (string) $bannerItem->created_at,
            'updated_at'  => (string) $bannerItem->updated_at,
            'deleted_at'  => (string) $bannerItem->deleted_at,
        ];
    }
}
