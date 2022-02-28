<?php

namespace App\Transformers;

use App\Models\MailHistory;
use Flugg\Responder\Transformers\Transformer;

class MailHistoryTransformer extends Transformer
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
     * @param \App\Models\MailHistory $mailHistory
     * @return array
     */
    public function transform(MailHistory $mailHistory)
    {
        return [
            'id'              => (string) $mailHistory->id,
            'email'           => (string) $mailHistory->email,
            'status'          => (string) $mailHistory->status,
            'company_tour_id' => (string) $mailHistory->company_tour_id,
            'content'         => (string) $mailHistory->content,
            'created_at'      => (string) $mailHistory->created_at,
            'updated_at'      => (string) $mailHistory->updated_at,
        ];
    }
}
