<?php

namespace App\Http\Requests;

use App\Supports\Traits\MenuLinkValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuLinkRequest extends FormRequest
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
            'menu_id'      => 'filled|string|exists:menus,id',
            'taxonomy_id'  => 'required_without_all:post_id,url|string|exists:taxonomies,id',
            'post_id'      => 'required_without_all:taxonomy_id,url|string|exists:posts,id',
            'url'          => 'required_without_all:taxonomy_id,post_id|string',
            'parent_id'    => 'nullable|string|exists:menulinks,id',
            'class'        => 'nullable|string',
            'title'        => 'filled|string',
            'additional'   => 'nullable|array',
        ];
    }
}
