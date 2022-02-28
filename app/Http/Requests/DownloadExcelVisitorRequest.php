<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Enums\MajorEnum;
use App\Enums\TourType;
use App\Enums\VisitorStatusEnum;
use App\Rules\FactoryTourPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DownloadExcelVisitorRequest extends FormRequest
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
            'filters.date'     => 'nullable|date_format:Y-m',
            'filters.location' => [
                'nullable',
                new FactoryTourPage()
            ],
            'filters.status'   => ['nullable', 'string', Rule::in(VisitorStatusEnum::asArray())],
            'filters.major'    => ['nullable', 'string', Rule::in(MajorEnum::asArray())],
            'filters.typeTour' => ['nullable', 'string', Rule::in(TourType::asArray())],
        ];
    }
}
