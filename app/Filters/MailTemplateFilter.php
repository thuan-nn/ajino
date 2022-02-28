<?php

namespace App\Filters;

class MailTemplateFilter extends Filter
{
    /**
     * @param $type
     * @return \App\Supports\Builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }

    /**
     * @param $email
     * @return \App\Supports\Builder
     */
    public function title($email)
    {
        return $this->query->whereLike('title', $email);
    }

    /**
     * @param $date
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function date($date)
    {
        return $this->query->whereDate('created_at', $date);
    }

    /**
     * @param $locale
     * @return \App\Supports\Builder
     */
    public function language($locale)
    {
        return $this->query->where('language', $locale);
    }
}
