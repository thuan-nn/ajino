<?php

namespace App\Supports\Traits;

trait SearchDefaultTranslations
{
    /**
     * @param $title
     * @return mixed
     */
    public function title($title)
    {
        return $this->query->whereUnicode($title, 'title');
    }

    /**
     * @param $slug
     *
     * @return \App\Supports\Builder
     */
    public function slug($slug)
    {
        return $this->query->whereTranslationLike('slug', '%'.$slug.'%');
    }

    /**
     * @return mixed
     */
    public function option()
    {
        $locale = request()->query('locale') ?? request()->header('App-Locale');

        return $this->query->translatedIn($locale);
    }
}
