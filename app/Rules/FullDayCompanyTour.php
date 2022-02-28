<?php

namespace App\Rules;

use App\Models\CompanyTour;
use Illuminate\Contracts\Validation\Rule;

class FullDayCompanyTour implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $companyTours = CompanyTour::query()->whereDate('date', $value)->get();

        if ($companyTours->count() == 2) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'có chắc yêu là đây';
    }
}
