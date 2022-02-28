<?php

namespace App\Http\Requests;

use App\Enums\LocationEnum;
use App\Rules\FactoryTourPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DownloadExcelCompanyTourRequest extends FormRequest
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
            'filters.location' => [
                'required',
                new FactoryTourPage()
            ],
            'filters.month'    => 'required|int|min:1|max:12',
            'filters.year'     => 'required|int',
        ];
    }
}
