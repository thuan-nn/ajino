<?php

namespace App\Builders;

use App\Filters\EloquentFilter;
use App\Supports\Builder;

class CompanyTourBuilder extends Builder implements EloquentFilter
{
    /**
     * @return \App\Builders\CompanyTourBuilder
     */
    public function dateApproveCompany()
    {
        return $this->whereDate('date', '>=', now()->startOfDay()->addWeek()->toDateString())
                    ->whereDate('date', '<=', now()->startOfDay()->addMonths(2)->toDateString());
    }

    /**
     * @return \App\Builders\CompanyTourBuilder
     */
    public function fullSlotVisit()
    {
        return $this->whereRaw('registry_amount < people_amount');
    }

    /**
     * @return \App\Builders\CompanyTourBuilder
     */
    public function dateExportCompanyTour()
    {
        return $this->whereDate('date', '<', now()->startOfDay()->toDateString());
    }

    /**
     * @return \App\Builders\CompanyTourBuilder
     */
    public function isCancel()
    {
        return $this->where('is_cancel', false);
    }
}