<?php

namespace App\Filters;

use App\Supports\Traits\SearchDefaultTranslations;

class   TaxonomyFilter extends Filter
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

    /**
     * @param $type
     * @return \App\Supports\Builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }

    /**
     * @param $page
     * @return \App\Supports\Builder
     */
    public function page($page)
    {
        return $this->query->where('page', $page);
    }

    /**
     *
     * @param $locale
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function has_locale($locale){
        return $this->query->whereHas('translations', function ($query) use ($locale) {
            $query->where('locale', $locale);
        });
    }
}
