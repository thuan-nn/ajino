<?php

namespace App\Http\Requests;

use App\Supports\Traits\MenuLinkValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateMenuLinkRequest extends FormRequest
{
    use MenuLinkValidation;

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
            'menulinks'              => 'required|array',
            'menulinks.*.menu_id'     => 'required|string|exists:menus,id',
            'menulinks.*.taxonomy_id' => 'string|exists:taxonomies,id',
            'menulinks.*.post_id'     => 'string|exists:posts,id',
            'menulinks.*.url'         => 'string',
            'menulinks.*.parent_id'   => 'nullable|string|exists:menulinks,id',
            'menulinks.*.class'       => 'nullable|string',
            'menulinks.*.title'       => 'required|string',
            'menulinks.*.additional'  => 'nullable|array',
        ];
    }
}
