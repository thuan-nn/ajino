<?php

namespace App\Filters;

use App\Builders\CompanyTourBuilder;
use Carbon\Carbon;

class VisitorFilter extends Filter
{
    /**
     * @param $status
     * @return \App\Supports\Builder
     */
    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    /**
     * @param $location
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function location($location)
    {
        return $this->query->whereHas('companyTour', function (CompanyTourBuilder $query) use ($location) {
            $query->where('location_id', $location);
        });
    }

    /**
     * @param $typeTour
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function typeTour($typeTour)
    {
        return $this->query->whereHas('companyTour', function (CompanyTourBuilder $query) use ($typeTour) {
            $query->where('type', $typeTour);
        });
    }

    /**
     * @param $date
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function date($date)
    {
        return $this->query->whereHas('companyTour', function (CompanyTourBuilder $query) use ($date) {
            $query->whereMonth('date', Carbon::parse($date)->month)
                  ->whereYear('date', Carbon::parse($date)->year);
        });
    }

    /**
     * @param $major
     * @return \App\Supports\Builder
     */
    public function major($major)
    {
        return $this->query->where('majors', $major);
    }
}
