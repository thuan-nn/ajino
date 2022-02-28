<?php


namespace App\Filters;


class FileFilter extends Filter {
    /**
     * @param $isPublished
     *
     * @return \App\Supports\Builder
     */
    public function is_published($isPublished) {
        return $this->query->where('is_published', $isPublished);
    }
}
