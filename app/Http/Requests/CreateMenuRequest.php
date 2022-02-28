<?php

namespace App\Http\Requests;

use App\Enums\MenuPageType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMenuRequest extends FormRequest
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
            'page'         => ['string', Rule::in(MenuPageType::asArray())],
            'class'        => 'nullable|string',
            'is_published' => 'boolean',
        ];
    }
}
