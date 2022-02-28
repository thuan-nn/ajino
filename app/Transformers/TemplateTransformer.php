<?php

namespace App\Transformers;

use App\Template;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Support\Str;

class TemplateTransformer extends Transformer
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
     * @param array $template
     * @return array
     */
    public function transform(array $template)
    {
        $result = [];
        foreach ($template as $id => $value) {
            array_push($result, [
                'key'   => $value,
                'value' => trans('languages.'.$id)
            ]);
        }

        return $result;
    }
}
