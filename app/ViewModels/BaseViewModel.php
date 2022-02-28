<?php

namespace App\ViewModels;

use App\Enums\FileTypeEnum;
use App\Enums\HomeSettingType;
use App\Enums\LanguageEnum;
use App\Enums\MenuTypeEnum;
use App\Enums\PageEnum;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class BaseViewModel extends ViewModel
{
    /** @var \Astrotomic\Translatable\string|void */
    protected $locale;

    /** @var string */
    protected $postId;

    /** @var \App\Models\Post */
    protected $currentPost;

    /** @var string */
    protected $postParentId;

    /** @var \App\Models\Post */
    protected $postParent;

    /** @var array */
    protected $globalData = [];

    /**
     * BaseViewModel constructor.
     *
     * @param array $globalData
     */
    public function __construct($globalData)
    {
        $this->locale = app()->getLocale() ?: LanguageEnum::VI;

        $this->globalData = $globalData;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function appUrl()
    {
        return config('app.url');
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function meta()
    {
        $additional = isset($this->currentPost->{'additional:'.$this->locale}) ?: null;

        $title = isset($this->currentPost->{'title:'. $this->locale}) ? $this->currentPost->{'title:'. $this->locale} : '';
        $description = isset($this->currentPost->{'description:'. $this->locale}) ? $this->currentPost->{'description:'. $this->locale} : '';

        return new Collection([
            'title'       => isset($additional['meta']['title']) && $additional['meta']['title'] ? $additional['meta']['title'] : $title,
            'description' => isset($additional['meta']['description']) && $additional['meta']['description'] ? $additional['meta']['description'] : $description,
        ]);
    }

    /**
     * @return string
     */
    public function locale()
    {
        return $this->locale;
    }

    public function getGeneralJs()
    {
        return $this->getSettingByKey(HomeSettingType::GENERALJSSETTING);
    }

    /**
     * Get logo
     *
     * @return mixed|null
     */
    public function logo()
    {
        return $this->getSettingByKey(HomeSettingType::LOGO);
    }

    /**
     * Get icon
     *
     * @return mixed|null
     */
    public function favicon()
    {
        return $this->getSettingByKey(HomeSettingType::FAVICON);
    }

    /**
     * Get slogan
     *
     * @return mixed|null
     */
    public function slogan()
    {
        return $this->getSettingByKey(HomeSettingType::SLOGAN);
    }

    /**
     * Get global links
     *
     * @return mixed|null
     */
    public function globalLinks()
    {
        return $this->getSettingByKey(HomeSettingType::GLOBAL_LINKS);
    }

    /**
     * Get global links
     *
     * @return mixed|null
     */
    public function jpLinks()
    {
        return $this->getSettingByKey(HomeSettingType::JP_LINKS);
    }

    /**
     * Get social network
     *
     * @return mixed|null
     */
    public function socialNetwork()
    {
        return $this->getSettingByKey(HomeSettingType::SOCIAL_NETWORK);
    }

    /**
     * Get copyright
     *
     * @return mixed|null
     */
    public function copyright()
    {
        return $this->getSettingByKey(HomeSettingType::COPYRIGHT);
    }

    /**
     * Get web links
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function webLinks()
    {
        return $this->getSettingByKey(HomeSettingType::HYPER_LINKED);
    }

    /**
     * Get setting cache by key
     *
     * @param $key
     * @return array|\ArrayAccess|mixed
     */
    public function getSettingByKey($key)
    {
        return Arr::get($this->globalData['settingData'], $key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getMenu($key)
    {
        if (! isset($this->globalData['menus']) || ! $this->globalData['menus']) {
            return null;
        }

        $menuCollections = $this->globalData['menus'];

        return $menuCollections->filter(function ($menu) use ($key) {
            return $menu->menu->type === $key;
        });
    }

    /**
     * @return mixed
     */
    public function mainLeftMenu()
    {
        return $this->getMenu(MenuTypeEnum::MAIN_LEFT);
    }

    /**
     * @return mixed
     */
    public function mainRightMenu()
    {
        return $this->getMenu(MenuTypeEnum::MAIN_RIGHT);
    }

    /**
     * @return mixed
     */
    public function footerTopLeftMenu()
    {
        return $this->getMenu(MenuTypeEnum::FOOTER_TOP_LEFT);
    }

    /**
     * @return mixed
     */
    public function footerTopMiddleMenu()
    {
        return $this->getMenu(MenuTypeEnum::FOOTER_TOP_MIDDLE);
    }

    /**
     * @return mixed
     */
    public function footerTopRightMenu()
    {
        return $this->getMenu(MenuTypeEnum::FOOTER_TOP_RIGHT);
    }

    /**
     * @return mixed
     */
    public function footerBottomMenu()
    {
        return $this->getMenu(MenuTypeEnum::FOOTER_BOTTOM);
    }

    /**
     * @return mixed
     */
    public function sitemap()
    {
        return Post::query()
                   ->isPublished()
                   ->translatedIn($this->locale)
                   ->whereTranslation('additional->page', PageEnum::SITEMAP)
                   ->first();
    }

    /**
     * @return string|null
     */
    public function filePaths() {
        if (!isset($this->currentPost)) {
            return null;
        }
        return getFilePath($this->currentPost, FileTypeEnum::POST, $this->locale);
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function fileListTitle()
    {
        if (!isset($this->currentPost)) {
            return null;
        }

        $additional = $this->currentPost->additional;

        return Arr::get($additional, 'file_list_name');
    }

    /**
     * Get home featured content
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function popup()
    {
        return $this->getSettingByKey(HomeSettingType::POPUP);
    }


    /**
     * Get home featured content
     *
     * @return array
     */
    public function advertise()
    {
        $data = [
            HomeSettingType::ADVERTISE => $this->getSettingByKey(HomeSettingType::ADVERTISE),
            HomeSettingType::ADVERTISE_IMAGE_PC => $this->getSettingByKey(HomeSettingType::ADVERTISE_IMAGE_PC),
            HomeSettingType::ADVERTISE_IMAGE_MOBILE => $this->getSettingByKey(HomeSettingType::ADVERTISE_IMAGE_MOBILE),
            HomeSettingType::ADVERTISE_IMAGE_SMALL => $this->getSettingByKey(HomeSettingType::ADVERTISE_IMAGE_SMALL)
        ];

        if (count($data) === 4) {
            return $data;
        }

        return [];
    }
}
