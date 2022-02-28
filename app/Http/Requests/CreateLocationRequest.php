<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLocationRequest extends FormRequest
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
            '*.id'           => 'nullable|string',
            '*.type'         => 'required|string',
            '*.name'         => 'required|string',
            '*.code'         => 'nullable|string',
            '*.content'      => 'nullable|array',
            '*.facebook_url' => 'nullable|string',
            '*.address'      => 'nullable|string',
            '*.name_en'      => 'nullable|string',
            '*.phone'        => 'nullable|string',
            '*.email'        => 'nullable|string',
            '*.additional'   => 'nullable|array',
            '*.is_delete'    => 'nullable|boolean',
        ];
    }
}
