<?php

namespace App\Sorts;

class CompanyTourSort extends Sort
{
    /**
     * @return \App\Supports\Builder
     */
    public function defaultSort()
    {
        return $this->query->latest('date');
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function type($direction)
    {
        return $this->query->orderByRaw("FIELD(type, 'morning','special-morning','afternoon','special-afternoon') ".$direction);
    }
}
