<?php

namespace App\Supports\Traits;

use App\Models\Visitor;

trait HandleMailHistoryData
{
    /**
     * @var
     */
    private $mailContent;

    /**
     * @param \App\Models\Visitor $visitor
     * @param $status
     * @return array
     */
    private function mailHistoryData(Visitor $visitor, $status): array
    {
        return [
            'email'           => $visitor->email,
            'status'          => $status,
            'company_tour_id' => $visitor->companyTour->id,
        ];
    }
}
