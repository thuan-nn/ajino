<?php

namespace App\Supports\Traits;

trait AdditionalTrait
{
    /**
     * @param $key
     * @param $value
     */
    public function addAdditional($key, $value)
    {
        $additional = json_decode($this->attributes['additional'] ?? "{}", false);
        $additional->{$key} = $value;
        $this->attributes['additional'] = json_encode($additional);
    }
}
