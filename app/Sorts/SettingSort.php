<?php

namespace App\Sorts;

class SettingSort extends Sort
{
    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function key($direction)
    {
        return $this->query->orderBy('key', $direction);
    }

    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function value($direction)
    {
        return $this->query->orderBy('value', $direction);
    }
}
