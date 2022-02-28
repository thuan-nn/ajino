<?php

namespace App\Filters;

class SettingFilter extends Filter
{
    /**
     * @param $key
     * @return \App\Supports\Builder
     */
    public function key($key)
    {
        return $this->query->whereLike('key', $key);
    }

    /**
     * @param $value
     * @return \App\Supports\Builder
     */
    public function value($value)
    {
        return $this->query->whereLike('value', $value);
    }
}