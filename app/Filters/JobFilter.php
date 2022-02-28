<?php

namespace App\Filters;

use App\Supports\Traits\SearchDefaultTranslations;

class JobFilter extends Filter
{
    use SearchDefaultTranslations;

    /**
     * @param $isPublished
     *
     * @return \App\Supports\Builder
     */
    public function is_published($isPublished)
    {
        return $this->query->where('is_published', $isPublished);
    }

    public function type($type)
    {
        return $this->query->where('type', $type);
    }
}
