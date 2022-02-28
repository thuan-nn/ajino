<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Enums\MajorEnum;
use App\Models\CompanyTour;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateVisitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_tour_id' => ['required', 'exists:company_tours,id'],
            'name'            => 'required|string',
            'address'         => 'required|string',
            'email'           => 'required|string|email',
            'phone_number'    => 'required|string|max:11',
            'amount_visitor'  => 'required|integer|max:'.$this->amountPeople().'|min:1',
            'majors'          => ['required', Rule::in(MajorEnum::asArray())],
            'job_location'    => 'required|string',
            'city'            => ['required', Rule::exists('locations', 'id')->where('type', LocationEnum::JOB)],
            'additional'      => 'nullable|array',
            'note'            => 'nullable|string',
        ];
    }

    /**
     * @return int
     */
    private function amountPeople(): int
    {
        $companyTour = CompanyTour::query()->findOrFail($this->company_tour_id);

        return $companyTour->people_amount - $companyTour->registry_amount;
    }
}
