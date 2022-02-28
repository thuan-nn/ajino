<?php

namespace App\Supports\Traits;

use App\Models\MenuLink;
use App\Models\MenuLinkTranslation;
use Illuminate\Support\Arr;

trait HandleNestedMenuLink
{
    /**
     * @var object $collectMenuLink
     */
    private $collectMenuLink;

    /**
     * @var array $fillableMenuLink
     */
    private $fillableMenuLink;

    /**
     * @param array $data
     * @return \Illuminate\Support\Collection
     */
    public function getMenuLinkId(array $data)
    {
        $menuLinks = Arr::get($data, 'menulinks');

        $translation = collect($menuLinks);

        return $translation->pluck('id');
    }

    /**
     * @param array $data
     * @param string $locale
     * @return array
     */
    public function getMenuLinkData(array $data, string $locale)
    {
        $fillable = $this->getFillableMenuLink();
        $collect = $this->getCollectionMenuLinkData($data, $locale);

        return $collect->map(function ($item) use ($fillable) {
            $menulink = Arr::only($item, $fillable);
            $menulink['id'] = $item['id'];
            $menulink['parent_id'] = $item['parent_id'] ?? null;
            return $menulink;
        })->toArray();
    }

    /**
     * @param $data
     * @param string $locale
     * @return array
     */
    private function getTranslationData($data, string $locale)
    {
        $fillable = $this->getFillableMenuLinkTranslation();
        $collect = $this->getCollectionMenuLinkData($data, $locale);

        return $collect->map(function ($item) use ($fillable) {
            $data = Arr::only($item, $fillable);
            $data['menu_link_id'] = $item['id'];
            return $data;
        })->toArray();
    }

    /**
     * @param array $data
     * @param $locale
     * @return \Illuminate\Support\Collection
     */
    private function getCollectionMenuLinkData(array $data, $locale)
    {
        $data = $this->handleData($data, $locale);

        return collect($data);
    }

    /**
     * @return array
     */
    private function getFillableMenuLink()
    {
        $menuLink = new MenuLink();

        return $menuLink->getFillable();
    }

    /**
     * @return array
     */
    private function getFillableMenuLinkTranslation()
    {
        $menuLinkTranslation = new MenuLinkTranslation();

        return $menuLinkTranslation->getFillable();
    }

    /**
     * @param array $data
     * @param $locale
     * @return array
     */
    public function handleData(array $data, $locale)
    {
        $menuLinks = Arr::get($data, 'menulinks');

        return array_map(function ($menulink) use ($locale) {
            $menulink['locale'] = $locale;

            return $menulink;
        }, $menuLinks);
    }
}
