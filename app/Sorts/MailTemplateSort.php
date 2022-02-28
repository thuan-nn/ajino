<?php

namespace App\Sorts;

class MailTemplateSort extends Sort
{
    /**
     * @param $direction
     * @return \App\Supports\Builder
     */
    public function created_at($direction)
    {
        return $this->query->orderBy('created_at', $direction);
    }
}
