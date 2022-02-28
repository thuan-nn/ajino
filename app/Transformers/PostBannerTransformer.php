<?php

namespace App\Transformers;

use App\Enums\LanguageEnum;
use App\Models\Banner;
use App\Models\BannerTranslation;
use App\Supports\Traits\PostBannerTrait;
use Flugg\Responder\Transformers\Transformer;

class PostBannerTransformer extends Transformer
{
    use PostBannerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'banners' => BannerTranslation::class,
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
            'id'              => (string) optional($banner->post)->id,
            'type'            => (string) optional($banner->post)->type,
            'is_published'    => (boolean) optional($banner->post)->is_published,
            'title'           => (string) optional($banner->post)->title,
            'language'        => $this->getBannerLanguage(optional($banner->post)),
            'created_at'      => (string) optional($banner->post)->created_at,
            'updated_at'      => (string) optional($banner->post)->updated_at,
        ];
    }
}
