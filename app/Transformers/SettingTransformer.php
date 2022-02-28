<?php

namespace App\Transformers;

use App\Models\Setting;
use Flugg\Responder\Transformers\Transformer;

class SettingTransformer extends Transformer
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
     * @param $settings
     * @return array
     */
    public function transform($settings)
    {
        return $settings->reduce(function ($result, $setting) {
            $result[$setting->key] = $setting->value;

            return $result;
        }, []);
    }
}
