<?php

namespace App\Rules;

use App\Models\CompanyTour;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class VisitDateRule implements Rule
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
        $companyTourDate = CompanyTour::query()->findOrFail($value)->date;

        if (Carbon::parse($companyTourDate)->lessThan(now()->startOfDay()->addWeeks(1))
            || Carbon::parse($companyTourDate)->greaterThan(now()->startOfDay()->addMonths(2))) {
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
        return 'Invalid Date';
    }
}
