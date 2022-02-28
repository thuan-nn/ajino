<?php

namespace App\Http\Requests;

use App\Enums\ReasonContactEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateContactUsRequest extends FormRequest
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
            'phone_number' => 'required|string|max:20',
            'email'        => 'required|string|email',
            'address'      => 'nullable|string',
            'reason'       => ['required', 'string', Rule::in(ReasonContactEnum::asArray())],
            'content'      => 'required|string',
            'fileId'       => 'nullable|exists:files,id',
        ];
    }
}
