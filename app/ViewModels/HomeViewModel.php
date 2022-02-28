<?php

namespace App\ViewModels;

use App\Enums\HomeSettingType;
use App\Enums\PostTypeEnum;
use App\Models\Banner;
use App\Models\Post;
use Illuminate\Support\Collection;

class HomeViewModel extends BaseViewModel
{
    public function __construct($globalData)
    {
        parent::__construct($globalData);
    }

    /**
     * Get banner
     *
     * @return mixed
     */
    public function banners()
    {
        /** @var Banner $banner */
        $banner = Banner::query()
                        ->where('is_published', 1)
                        ->whereTranslation('locale', $this->locale)
                        ->whereNull('post_id')
                        ->first();

        if (! $banner || ! isset($banner->{'additional:'.$this->locale}['items'])) {
            return null;
        }

        $collection =  new Collection($banner->{'additional:'.$this->locale}['items']);
        return $collection->sortBy('order');
    }

    /**
     * Get posts of story which have key is_home
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function stories()
    {
        return Post::query()
                   ->where(function ($query) {
                     $query->whereType(PostTypeEnum::STORY_GROUP)
                           ->orWhere('type', PostTypeEnum::STORY_VN);
                   })
                   ->where('is_published', '=', 1)
                   ->whereTranslation('additional->is_home', true)
                   ->orderBy('order')
                   ->orderByDesc('updated_at')
                   ->get()
                   ->take(3);
    }

    /**
     * Get notice
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function notices()
    {
        $notice = $this->getSettingByKey(HomeSettingType::NOTICE);

        if (! isset($notice['from']) || ! isset($notice['to']) || ! isset($notice['is_published']) || ! $notice['is_published']) {
            return null;
        }

        $isAllowNotice = checkDateFromTo($notice['from'], $notice['to']);

        return $isAllowNotice ? $notice : null;
    }

    /**
     * Get story
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function storyHome()
    {
        return $this->getSettingByKey(HomeSettingType::STORY);
    }

    /**
     * Get home featured post
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function featuredPosts()
    {
        return $this->getSettingByKey(HomeSettingType::HOME_FEATURED_POST);
    }

    /**
     * Get home featured content
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function featuredContents()
    {
        return $this->getSettingByKey(HomeSettingType::HOME_FEATURED_CONTENT);
    }

    /**
     * Get web links
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function webLinks()
    {
        return $this->getSettingByKey(HomeSettingType::WEB_LINKED);
    }
}
