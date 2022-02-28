<?php

namespace App\Transformers;

use App\Models\JobTranslation;
use Flugg\Responder\Transformers\Transformer;

class JobTranslationTransformer extends Transformer
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
     * @param \App\Models\JobTranslation $jobTranslation
     * @return array
     */
    public function transform(JobTranslation $jobTranslation)
    {
        return [
            'id'          => (string) $jobTranslation->id,
            'job_id'      => (string) $jobTranslation->job_id,
            'title'       => (string) $jobTranslation->title,
            'slug'        => (string) $jobTranslation->slug,
            'description' => (string) $jobTranslation->description,
            'job_type'    => (string) $jobTranslation->job_type,
            'salary'      => $jobTranslation->salary,
            'locale'      => (string) $jobTranslation->locale,
            'is_feature'  => (boolean) $jobTranslation->is_feature,
            'addtional'   => $jobTranslation->additional,
            'created_by'  => (string) $jobTranslation->created_by,
            'updated_by'  => (string) $jobTranslation->updated_by,
            'deleted_by'  => (string) $jobTranslation->deleted_by,
        ];
    }
}
