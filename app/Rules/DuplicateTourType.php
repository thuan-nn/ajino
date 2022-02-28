<?php

namespace App\Rules;

use App\Enums\TourType;
use App\Models\CompanyTour;
use Illuminate\Contracts\Validation\Rule;

class DuplicateTourType implements Rule
{
    /**
     * @var string
     */
    protected $date;

    /**
     * @var
     */
    protected $companyTourId;

    /**
     * TourTypeRule constructor.
     *
     * @param string $date
     * @param null $companyTourId
     */
    public function __construct(string $date, $companyTourId = null)
    {
        $this->date = $date;
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
        $tourMorning = [TourType::MORNING, TourType::SPECIAL_MORNING];
        $tourAfternoon = [TourType::AFTERNOON, TourType::SPECIAL_AFTERNOON];
        if (! is_null($this->companyTourId)) {
            $companyTours = CompanyTour::query()->whereDate('date', $this->date)
                                       ->whereKeyNot($this->companyTourId)->get();
        } else {
            $companyTours = CompanyTour::query()->whereDate('date', $this->date)->get();
        }
        if ($companyTours->count() !== 0) {
            foreach ($companyTours as $companyTour) {
                if ((in_array($companyTour->type, $tourMorning) && in_array($value, $tourMorning)) ||
                    (in_array($companyTour->type, $tourAfternoon) && in_array($value, $tourAfternoon))) {
                    return false;
                }
            }
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
        return 'co su kien roi chon ngay khac di ma';
    }
}
