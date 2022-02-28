<?php

namespace App\Sorts;

class LocationSort extends Sort
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
    public function code($direction)
    {
        return $this->query->orderBy('code', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function name($direction)
    {
        return $this->query->orderBy('name', $direction);
    }
}
