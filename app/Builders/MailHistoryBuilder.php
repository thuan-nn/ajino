<?php

namespace App\Builders;

use App\Filters\EloquentFilter;
use App\Supports\Builder;

class MailHistoryBuilder extends Builder implements EloquentFilter
{
    /**
     * @param $status
     * @return \App\Builders\MailHistoryBuilder
     */
    public function status($status)
    {
        if (! is_null($status)) {
            return $this->whereIn('status', $status);
        }

        return $this;
    }
}
