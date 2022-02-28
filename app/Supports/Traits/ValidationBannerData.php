<?php

namespace App\Supports\Traits;

use Illuminate\Support\Arr;

trait ValidationBannerData
{
    /**
     * @return array
     */
    private function getOrder()
    {
        $bannerContents = Arr::get($this->toArray(), 'banner_contents');

        return array_map(function ($bannerContent) {
            return $bannerContent['order'];
        }, $bannerContents);
    }
}
