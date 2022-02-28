<?php

namespace App\Transformers;

use App\Enums\LanguageEnum;
use App\Models\Menu;
use App\Models\MenuLink;
use Flugg\Responder\Transformers\Transformer;

class MenuTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'menulinks' => MenuLinkTransformer::class,
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
     * @param Menu $menu
     *
     * @return array
     */
    public function transform(Menu $menu)
    {
        return [
            'id'           => (string) $menu->id,
            'name'         => (string) $menu->name,
            'class'        => (string) $menu->class,
            'is_published' => (bool) $menu->is_published,
            'page'         => (string) $menu->page,
            'language'     => (array) $this->getLanguage($menu),
            'created_at'   => (string) $menu->created_at,
            'updated_at'   => (string) $menu->updated_at,
        ];
    }

    /**
     * Filter included shipments.
     *
     * @param \Illuminate\Database\Eloquent\Collection $menulinks
     * @return \Illuminate\Support\Collection
     */
    public function filterMenulinks($menulinks)
    {
        $locale = request()->get('locale') ?? request()->header('App-Locale');

        return $menulinks->filter(function (MenuLink $menulink) use ($locale) {
            return $menulink->hasTranslation($locale);
        })->sortBy('order')->toTree();
    }

    /**
     * @param \App\Models\Menu $menu
     * @return array
     */
    private function getLanguage(Menu $menu)
    {
        return [
            LanguageEnum::EN => $this->countMenuLink($menu, LanguageEnum::EN),
            LanguageEnum::VI => $this->countMenuLink($menu, LanguageEnum::VI),
        ];
    }

    /**
     * @param \App\Models\Menu $menu
     * @param $language
     * @return bool
     */
    private function countMenuLink(Menu $menu, $language)
    {
        $menuLinks = $menu->menulinks;
        $filter = $menuLinks->filter(function ($value, $key) use ($language) {
            return $value->hasTranslation($language);
        })->count();

        if ($filter !== 0) {
            return true;
        }

        return false;
    }
}
