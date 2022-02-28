<?php

namespace App\Filters;

use App\Enums\LocationEnum;

class LocationFilter extends Filter
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
     * @param $name
     * @return \App\Supports\Builder
     */
    public function name($name)
    {
        return $this->query->whereLike('name', $name);
    }

    public function tour_page($value)
    {
        if ($value) {
            return $this->query->where('additional->tour_page', '=', 'true');
        } else {
            $this->query->where('additional->contact_page', '=', true);
        }
    }
}
