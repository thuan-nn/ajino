<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Enums\TourType;
use App\Rules\FactoryTourPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompanyTourRequest extends FormRequest
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
            'location_id'           => [
                'required',
                new FactoryTourPage(),
            ],
            'dates'                 => 'required|array',
            'dates.*'               => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after:now',
            ],
            'tours'                 => 'required|array',
            'tours.*.type'          => [
                'required',
                Rule::in(TourType::asArray()),
            ],
            'tours.*.people_amount' => 'required|integer',
            'tours.*.description'   => 'nullable|string',
            'tours.*.is_cancel'     => 'boolean',
        ];
    }
}
