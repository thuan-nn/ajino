<?php


namespace App\Filters;


class MenuFilter extends Filter {
    /**
     * @param $name
     *
     * @return \App\Supports\Builder
     */
    public function name($name) {
        return $this->query->whereLike('name', $name);
    }

    /**
     * @param $isPublished
     *
     * @return \App\Supports\Builder
     */
    public function is_published($isPublished) {
        return $this->query->where('is_published', $isPublished);
    }
}
