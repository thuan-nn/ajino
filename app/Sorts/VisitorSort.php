<?php

namespace App\Sorts;

class VisitorSort extends Sort
{
    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function created_at($direction)
    {
        return $this->query->orderBy('created_at', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function date($direction)
    {
        return $this->query->join('company_tours', 'company_tours.id', '=', 'visitors.company_tour_id')
                           ->orderBy('company_tours.date', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function tourType($direction)
    {
        return $this->query->join('company_tours', 'company_tours.id', '=', 'visitors.company_tour_id')
                           ->orderBy('company_tours.type', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function status($direction)
    {
        return $this->query->orderBy('status', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function registry_amount($direction)
    {
        return $this->query->join('company_tours', 'company_tours.id', '=', 'visitors.company_tour_id')
                           ->orderBy('company_tours.registry_amount', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function majors($direction)
    {
        return $this->query->orderBy('majors', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function job_location($direction)
    {
        return $this->query->orderBy('job_location', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function created_by($direction)
    {
        return $this->query->orderBy('created_by', $direction);
    }
}
