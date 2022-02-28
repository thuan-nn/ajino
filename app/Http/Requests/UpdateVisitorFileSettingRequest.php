<?php

namespace App\Http\Requests;

use App\Enums\VisitorFileType;
use App\Models\VisitorFileSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVisitorFileSettingRequest extends FormRequest
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
            'is_active' => 'required|boolean',
            'type'      => ['required', 'string', Rule::in(VisitorFileType::asArray())],
        ];
    }
}
