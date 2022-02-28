<?php

namespace App\Transformers;

use App\Models\Visitor;
use Carbon\Carbon;
use Flugg\Responder\Transformers\Transformer;

class VisitorTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [
        'companyTour' => CompanyTourTransformer::class,
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
     * @param \App\Models\Visitor $visitor
     * @return array
     */
    public function transform(Visitor $visitor)
    {
        return [
            'id'             => (string) $visitor->id,
            'name'           => (string) $visitor->name,
            'address'        => (string) $visitor->address,
            'email'          => (string) $visitor->email,
            'phone_number'   => (string) $visitor->phone_number,
            'amount_visitor' => (int) $visitor->amount_visitor,
            'note'           => (string) $visitor->note,
            'majors'         => (string) $visitor->majors,
            'job_location'   => (string) $visitor->job_location,
            'city'           => (string) $visitor->city,
            'status'         => (string) $visitor->status,
            'created_at'     => (string) Carbon::parse($visitor->created_at)->format('d-m-Y'),
            'created_by'     => (string) is_null($visitor->created_by) ? 'user' : 'admin',
            'additional'     => (array) $visitor->additional,
        ];
    }

    /**
     * @param \App\Models\Visitor $visitor
     * @return mixed
     */
    public function includeCompanyTour(Visitor $visitor)
    {
        if (! $visitor->companyTour) {
            return null;
        }
        $visitor->companyTour->date = Carbon::parse($visitor->companyTour->date)->format('d-m-Y');

        return $visitor->companyTour;
    }
}
