<?php

namespace App\Filters;

class VisitorFileSettingFilter extends Filter
{
    /**
     * @param $isActive
     * @return \App\Supports\Builder
     */
    public function is_active($isActive)
    {
        return $this->query->where('is_active', $isActive);
    }

    /**
     * @param $type
     * @return \App\Supports\Builder
     */
    public function type($type)
    {
        return $this->query->where('type', $type);
    }
}
