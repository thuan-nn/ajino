<?php


namespace App\Supports\Traits;


use App\Supports\Builder;

trait DefaultSort
{
    /**
     * @return Builder
     */
    public function defaultSort() {
        return $this->query->latest('updated_at');
    }
}
