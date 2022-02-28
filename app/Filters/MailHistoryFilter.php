<?php

namespace App\Filters;

class MailHistoryFilter extends Filter
{
    /**
     * @param $status
     * @return \App\Supports\Builder
     */
    public function status($status)
    {
        return $this->query->where('status', $status);
    }

    /**
     * @param $email
     * @return \App\Supports\Builder
     */
    public function email($email)
    {
        return $this->query->whereLike('email', $email);
    }

    /**
     * @param $date
     * @return \App\Supports\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function date($date)
    {
        return $this->query->whereDate('created_at', $date);
    }
}
