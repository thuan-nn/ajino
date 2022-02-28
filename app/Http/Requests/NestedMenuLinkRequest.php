<?php

namespace App\Http\Requests;

use App\Supports\Traits\MenuLinkValidation;
use Illuminate\Foundation\Http\FormRequest;

class NestedMenuLinkRequest extends FormRequest
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
            'menu_id'                 => 'filled|string|exists:menus,id',
            'menulinks'               => 'nullable|array',
            'menulinks.*.id'          => 'required|exists:menulinks,id',
            'menulinks.*.taxonomy_id' => 'required_without_all:menulinks.*.post_id,menulinks.*.url|nullable|string|exists:taxonomies,id',
            'menulinks.*.post_id'     => 'required_without_all:menulinks.*.taxonomy_id,menulinks.*.url|nullable|string|exists:posts,id',
            'menulinks.*.url'         => 'required_without_all:menulinks.*.taxonomy_id,menulinks.*.post_id|nullable|string',
            'menulinks.*.parent_id'   => 'nullable|string|exists:menulinks,id',
            'menulinks.*.class'       => 'nullable|string',
            'menulinks.*.title'       => 'filled|string',
            'menulinks.*.additional'  => 'nullable|array',
        ];
    }
}
