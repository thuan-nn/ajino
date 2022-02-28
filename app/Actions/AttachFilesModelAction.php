<?php

namespace App\Actions;

use App\Models\File;
use App\Models\PostTranslation;
use Illuminate\Support\Arr;

class AttachFilesModelAction
{
    public function execute(string $modelId, string $modelType, array $data)
    {

        switch ($modelType) {
            case 'posttranslation':
                $locale = Arr::get($data, 'locale');
                $fileIds = Arr::get($data, 'file_ids');

                $translation = PostTranslation::query()->where('locale', $locale)->findOrFail($modelId);
                $files = File::query()->whereIn('id', $fileIds)->get();
                $translation->files()->attach($files);
                break;
        }
    }
}
