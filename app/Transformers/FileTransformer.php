<?php

namespace App\Transformers;

use App\Models\File;
use Flugg\Responder\Transformers\Transformer;

class FileTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\File $file
     *
     * @return array
     */
    public function transform(File $file)
    {
        return [
            'id'           => (string) $file->id,
            'name'         => (string) $file->name,
            'is_published' => (bool) $file->is_published,
            'mime_type'    => (string) $file->mime_type,
            'type'         => (string) $file->type,
            'size'         => (int) $file->size,
            'disk'         => (string) $file->disk,
            'name_file'    => (string) $file->name_file,
            'path'         => (string) $file->path,
            'url'          => (string) $file->url,
            'additional'   => (object) $file->additional,
            'created_at'   => $file->created_at,
            'updated_at'   => $file->updated_at,
        ];
    }
}
