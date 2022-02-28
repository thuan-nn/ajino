<?php

namespace App\Rules;

use App\Enums\LocationEnum;
use App\Models\CompanyTour;
use App\Models\Location;
use Illuminate\Contracts\Validation\Rule;

class FactoryTourPage implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Location::query()->where('id', $value)->where('type', LocationEnum::VISIT)
                                     ->where('additional->tour_page', true)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.factory_tour_page');
    }
}
