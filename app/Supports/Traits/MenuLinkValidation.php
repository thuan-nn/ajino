<?php

namespace App\Supports\Traits;

use Illuminate\Support\Arr;

trait MenuLinkValidation
{
    /**
     * @param $validator
     */
    public function withValidator($validator)
    {
        $arrayCheck = Arr::only($this->toArray(), ['taxonomy_id', 'post_id', 'url']);
        $fields = implode(',', array_keys($arrayCheck));
        $validator->after(function ($validator) use ($arrayCheck, $fields) {
            $count = count(array_values($arrayCheck));
            if ($count > 1) {
                $validator->errors()->add($fields, 'You must choose one from '.$count.' field!');
            }
        });
    }
}