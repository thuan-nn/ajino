<?php

namespace App\Supports\Traits;

use Illuminate\Support\Arr;

trait HandleBannerData
{
    /**
     * @param $data
     * @return array
     */
    private function handleDataHasVideoUrl($data)
    {
        $bannerItems = Arr::get($data, 'banner_item');

        $bannerData = Arr::except($data, 'banner_item');

        return array_map(function ($item) use ($bannerData) {
            $urlVideo = Arr::get($item, 'video_url');
            if (! empty($urlVideo)) {
                $item['video_url'] = $this->handleUrlVideo($urlVideo);
            }

            $item['is_published'] = $bannerData['is_published'];
            $item['type_slide'] = $bannerData['type_slide'];

            return $item;
        }, $bannerItems);
    }

    /**
     * @param $model
     * @param $data
     * @param $locale
     */
    private function attachFileBanner($model, $data, $locale)
    {
        $images = Arr::get($data, 'images');

        $fileIds = $images[0]['id'] ?? [];

        $model->translate($locale)->files()->sync($fileIds);
    }
}
