<?php

namespace App\Supports\Traits;

use Illuminate\Support\Arr;

trait HandleMenuLinksTranslations
{
    /**
     * @param array $data
     * @param string $locale
     * @param $model
     * @return array
     */
    private function handleData(array $data, $locale, $model)
    {
        $fillable = $model->getFillable();

        $dataMenuLinks = Arr::get($data,'menulinks');

        return array_map(function ($item) use ($fillable, $locale) {
            $fillableData = Arr::only($item, $fillable);
            $translationData = Arr::except($item, $fillable);

            return array_merge($fillableData, [$locale => $translationData]);
        }, $dataMenuLinks);
    }
}
