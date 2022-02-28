<?php

namespace App\Supports\Traits;

use App\Models\Banner;
use Illuminate\Support\Collection;

trait ShowBannerTrait
{
    protected $banner;

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function banners()
    {
        $banner = Banner::query()
                        ->where('is_published', 1)
                        ->whereTranslation('locale', $this->locale)
                        ->when($this->currentPost, function ($query) {
                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                            return $query->where('post_id', $this->currentPost->id);
                        })
                        ->first();

        if (! $banner || ! isset($banner->{'additional:'.$this->locale}['items'])) {
            return null;
        }

        $this->banner = $banner;

        $collection =  new Collection($banner->{'additional:'.$this->locale});

        $collectionArray = $collection['items'];

        usort($collectionArray, function ($a, $b) {
           return (int) $a['order'] <=> (int) $b['order'];
        });

        $collection['items'] = $collectionArray;

        return $collection;
    }

    /**
     * @return bool
     */
    public function isMultipleTypeSlide()
    {
        $banner = $this->banner;

        return $banner && ($banner->type_slide === \App\Enums\BannerSlideTypeEnum::MULTIPLE);
    }

    /**
     * @return bool
     */
    public function isSingleTypeSlide()
    {
        $banner = $this->banner;

        return $banner && ($banner->type_slide === \App\Enums\BannerSlideTypeEnum::SINGLE);
    }
}
