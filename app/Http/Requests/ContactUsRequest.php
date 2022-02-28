<?php

namespace App\Http\Requests;

use App\Enums\ReasonContactEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactUsRequest extends FormRequest
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
            'reason'       => ['required', 'string', Rule::in(ReasonContactEnum::asArray())],
            'content'      => 'required|string',
            'name'         => 'required|string',
            'phone_number' => 'required|string|max:20',
            'address'      => 'nullable|string',
            'email'        => 'required|string|email',
            'files'        => 'nullable|array',
            'files.*'      => 'nullable|mimes:jpg,png,jpeg,doc,docx,pdf|max:5120',
        ];
    }
}
