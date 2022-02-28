<?php


namespace App\Sorts;


class RoleSort extends Sort
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
    public function name($direction)
    {
        return $this->query->orderBy('name', $direction);
    }
}
