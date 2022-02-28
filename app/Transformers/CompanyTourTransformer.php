<?php

namespace App\Transformers;

use App\Models\CompanyTour;
use Flugg\Responder\Transformers\Transformer;

class CompanyTourTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'visitors' => VisitorTransformer::class,
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
     * @param \App\Models\CompanyTour $companyTour
     * @return array
     */
    public function transform(CompanyTour $companyTour)
    {
        return [
            'id'                 => (string) $companyTour->id,
            'location'           => (string) $this->getLocationName($companyTour),
            'type'               => (string) $companyTour->type,
            'date'               => (string) $companyTour->date,
            'description'        => (string) $companyTour->description,
            'people_amount'      => (int) $companyTour->people_amount,
            'registry_amount'    => (int) $companyTour->registry_amount,
            'participant_amount' => (int) $companyTour->participant_amount,
            'is_published'       => (boolean) $companyTour->is_published,
            'is_cancel'          => (boolean) $companyTour->is_cancel,
            'additional'         => $companyTour->additional,
            'created_at'         => $companyTour->created_at,
            'updated_at'         => $companyTour->updated_at,
        ];
    }

    /**
     * @param \App\Models\CompanyTour $companyTour
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|\Illuminate\Support\HigherOrderCollectionProxy|mixed
     */
    private function getLocationName(CompanyTour $companyTour)
    {
        return $companyTour->location()->find($companyTour->location_id)->display_name;
    }
}
