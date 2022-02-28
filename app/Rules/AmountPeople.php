<?php

namespace App\Rules;

use App\Models\CompanyTour;
use Illuminate\Contracts\Validation\Rule;

class AmountPeople implements Rule
{
    /**
     * @var
     */
    protected $companyTourId;

    /**
     * AmountPeople constructor.
     *
     * @param null $companyTourId
     */
    public function __construct($companyTourId = null)
    {
        $this->companyTourId = $companyTourId;
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
        if (! is_null($this->companyTourId)) {
            $companyTour = CompanyTour::query()->find($this->companyTourId);
            $amountPeople = $companyTour->registry_amount;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
