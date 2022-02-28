<?php

namespace App\Transformers;

use App\Models\VisitorFileSetting;
use Flugg\Responder\Transformers\Transformer;

class VisitorFileSettingTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'files' => FileTransformer::class,
    ];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @return array
     */
    public function transform(VisitorFileSetting $visitorFileSetting)
    {
        return [
            'id'         => (string) $visitorFileSetting->id,
            'type'       => (string) $visitorFileSetting->type,
            'file_name'  => (string) optional($visitorFileSetting->files)->first()->name,
            'file_id'    => (string) optional($visitorFileSetting->files)->first()->id,
            'is_active'  => (boolean) $visitorFileSetting->is_active,
            'created_at' => (string) $visitorFileSetting->created_at,
            'updated_at' => (string) $visitorFileSetting->updated_at,
        ];
    }
}
