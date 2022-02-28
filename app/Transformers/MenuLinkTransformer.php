<?php

namespace App\Transformers;

use App\Models\MenuLink;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;

class MenuLinkTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * @var string $slug
     */
    private $slug;

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
     * @param \App\Models\MenuLink $menuLink
     *
     * @return array
     */
    public function transform(MenuLink $menuLink)
    {
        return [
            'id'          => (string) $menuLink->id,
            'menu_id'     => (string) $menuLink->menu_id,
            'taxonomy_id' => (string) $menuLink->taxonomy_id,
            'post_id'     => (string) $menuLink->post_id,
            'parent_id'   => (string) $menuLink->parent_id,
            'slug'        => (string) $menuLink->slug,
            'url'         => (string) $menuLink->url,
            'class'       => (string) $menuLink->class,
            'title'       => (string) $menuLink->title,
            'locale'      => (string) $menuLink->locale,
            'language'    => (array) $menuLink->language,
            'type'        => (string) $menuLink->type,
            'additional'  => (array) $menuLink->additional,
            'created_at'  => (string) $menuLink->created_at,
            'updated_at'  => (string) $menuLink->updated_at,
            'children'    => $menuLink->children,
        ];
    }
}
