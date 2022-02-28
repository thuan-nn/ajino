<?php

namespace App\Builders;

use App\Filters\EloquentFilter;
use App\Supports\Builder;
use Carbon\Carbon;

class VisitorBuilder extends Builder implements EloquentFilter
{
    /**
     * @param $status
     * @return \App\Builders\VisitorBuilder
     */
    public function status($status)
    {
        if (! is_null($status)) {
            return $this->whereIn('status', $status);
        }

        return $this;
    }

    /**
     * @param $date
     * @return $this
     */
    public function month($date)
    {
        return $this->whereHas('companyTour', function (CompanyTourBuilder $query) use ($date) {
            $query->whereMonth('date', '=', Carbon::parse($date)->month);
        });
    }
}
