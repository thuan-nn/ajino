<?php

namespace App\Supports\Traits;

use Illuminate\Support\Arr;

trait HandleTranslations
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

        $modelData = Arr::only($data, $fillable);

        $translationData = Arr::except($data, $fillable);

        return array_merge($modelData, [$locale => $translationData]);
    }

    /**
     * @param $model
     * @param array $data
     * @param string $locale
     */
    private function attachFiles($model, array $data, string $locale)
    {
        $fileIds = Arr::get($data, 'fileIds') ?? [];

        $model->translate($locale)->files()->sync($fileIds);
    }
}
