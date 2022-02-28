<?php

namespace App\Http\Requests;

use App\Enums\PostTypeEnum;
use App\Enums\TaxonomyEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTaxonomyRequest extends FormRequest
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
            'type'         => ['required', 'string', Rule::in(TaxonomyEnum::asArray())],
            'order'        => 'integer',
            'is_published' => 'boolean',
            'title'        => 'required|string',
            'slug'         => [
                'nullable',
                'string',
                Rule::unique('taxonomy_translations', 'slug'),
                Rule::unique('post_translations', 'slug'),
            ],
            'page'         => [
                Rule::requiredIf(function () {
                    return $this->type === TaxonomyEnum::CATEGORY;
                }),
                Rule::in(PostTypeEnum::asArray()),
            ],
            'additional'   => 'nullable|array',
            'fileIds'      => 'nullable|array|exists:files,id',
        ];
    }
}
