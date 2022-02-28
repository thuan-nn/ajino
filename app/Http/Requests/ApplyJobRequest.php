<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
            'name'         => 'required|string',
            'gender'       => 'nullable|boolean',
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|email',
            'files'        => 'required|array',
            'files.*'      => 'mimes:doc,docx,pdf,jpg,png,jpeg|max:5120',
        ];
    }
}
