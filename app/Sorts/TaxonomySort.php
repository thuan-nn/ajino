<?php

namespace App\Sorts;

class TaxonomySort extends Sort
{
    /**
     * @param $direction
     *
     * @return \App\Supports\Builder
     */
    public function created_at($direction)
    {
        return $this->query->orderBy('created_at', $direction);
    }

    /**
     * @param $direction
     *
     * @return \App\Supports\Builder
     */
    public function updated_at($direction)
    {
        return $this->query->orderBy('updated_at', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function order($direction)
    {
        return $this->query->orderBy('order', $direction);
    }
}
