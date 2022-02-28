<?php

namespace App\Sorts;

class VisitorFileSettingSort extends Sort
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
     *
     * @return \App\Supports\Builder
     */
    public function is_active($direction)
    {
        return $this->query->orderBy('is_active', $direction);
    }

    /**
     * @param $direction
     *
     * @return \App\Supports\Builder
     */
    public function type($direction)
    {
        return $this->query->orderBy('type', $direction);
    }
}
