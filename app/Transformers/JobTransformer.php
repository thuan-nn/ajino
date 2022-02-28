<?php

namespace App\Transformers;

use App\Models\Job;
use App\Supports\Traits\TransformerTrait;
use Flugg\Responder\Transformers\Transformer;

class JobTransformer extends Transformer
{
    use TransformerTrait;

    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'taxonomies' => TaxonomyTransformer::class,
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
     * @param \App\Models\Job $job
     * @return array
     */
    public function transform(Job $job)
    {
        $thumbnails = $this->checkTranslateRelations($job, $this->locale);

        return [
            'id'           => (string) $job->id,
            'is_published' => (boolean) $job->is_published,
            'title'        => (string) $job->title,
            'location_id'  => (string) $job->location_id,
            'slug'         => (string) $job->slug,
            'description'  => (string) $job->description,
            'salary'       => is_null($job->salary) ? $job->salary : $this->getSalary($job->salary),
            'job_type'     => (string) $job->job_type,
            'locale'       => (string) $job->locale,
            'is_feature'   => (boolean) $job->is_feature,
            'additional'   => $job->additional,
            'language'     => (array) $job->language,
            'images'       => $thumbnails ? thumbnail($thumbnails->files()->pluck('id')) : [], // thumbnail
            'order'        => (int)    $job->order,
            'created_at'   => (string) $job->created_at,
            'created_by'   => (string) $job->created_by,
            'updated_by'   => (string) $job->updated_by,
            'updated_at'   => (string) $job->updated_at,
            'deleted_by'   => (string) $job->deleted_by,
        ];
    }

    /**
     * @param $salary
     * @return |null
     */
    private function getSalary($salary)
    {
        if ($salary['from'] === null && $salary['to'] === null) {
            return null;
        }

        return $salary;
    }
}
