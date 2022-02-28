<?php

namespace App\Http\Requests;

use App\Enums\ReasonContactEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactUsRequest extends FormRequest
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
            'phone_number' => 'filled|string|max:20',
            'email'        => 'filled|string|email',
            'address'      => 'nullable|string',
            'reason'       => ['filled', 'string', Rule::in(ReasonContactEnum::asArray())],
            'content'      => 'filled|string',
            'fileId'       => 'nullable|exists:files,id',
        ];
    }
}
