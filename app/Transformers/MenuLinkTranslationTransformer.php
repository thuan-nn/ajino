<?php

namespace App\Transformers;

use App\Models\MenulinkTranslation;
use Flugg\Responder\Transformers\Transformer;

class MenuLinkTranslationTransformer extends Transformer {
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'menulink' => MenuLinkTransformer::class
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
     * @param MenulinkTranslation $menulinkTranslation
     *
     * @return array
     */
    public function transform(MenulinkTranslation $menulinkTranslation) {
        return [
            'id'          => (string)$menulinkTranslation->id,
            'menu_link_id' => (string)$menulinkTranslation->menu_link_id,
            'title'       => (string)$menulinkTranslation->title,
            'slug'        => (string)$menulinkTranslation->slug,
            'locale'      => (string)$menulinkTranslation->locale,
            'url'         => (string)$menulinkTranslation->url,
            'additional'  => (array)$menulinkTranslation->additional
        ];
    }
}
