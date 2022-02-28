<?php


namespace App\Sorts;


class PermissionSort extends Sort
{
    /**
     * @param $direction
     *
     * @return \App\Supports\Builder
     */
    public function name($direction)
    {
        return $this->query->orderBy('name', $direction);
    }
}
