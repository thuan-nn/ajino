<?php

namespace App\Transformers;

use App\Models\BannerItemTranslation;
use Flugg\Responder\Transformers\Transformer;

class BannerItemTranslationTransformer extends Transformer
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
     * @param  \App\Models\BannerItemTranslation $bannerItemTranslation
     * @return array
     */
    public function transform(BannerItemTranslation $bannerItemTranslation)
    {
        return [
            'id' => (int) $bannerItemTranslation->id,
        ];
    }
}
