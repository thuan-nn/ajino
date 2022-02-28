<?php

namespace App\Filters;

class CompanyTourFilter extends Filter
{
    /**
     * @param $location
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function location($location)
    {
        return $this->query->where('location_id', $location);
    }

    /**
     * @param $date
     * @return \App\Supports\Builder
     */
    public function date($date)
    {
        return $this->query->whereDate('date', $date);
    }

    /**
     * @param $month
     * @return \App\Supports\Builder
     */
    public function month($month)
    {
        return $this->query->whereMonth('date', $month);
    }

    /**
     * @param $year
     * @return \App\Supports\Builder
     */
    public function year($year)
    {
        return $this->query->whereYear('date', $year);
    }

    /**
     * @param $type
     * @return \App\Supports\Builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }
}
