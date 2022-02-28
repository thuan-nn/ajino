<?php

namespace App\Http\Requests;

use App\Enums\FileTypeEnum;
use App\Enums\PostTypeEnum;
use App\Enums\TemplateEnum;
use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
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
            'type'                          => ['required', 'string', Rule::in(PostTypeEnum::asArray())],
            'parent_id'                     => 'nullable|string|exists:posts,id',
            'is_published'                  => 'boolean',
            'order'                         => 'integer',
            'title'                         => 'required|string',
            'description'                   => 'nullable|string',
            'slug'                          => [
                'nullable',
                'string',
                Rule::unique('taxonomy_translations', 'slug'),
                Rule::unique('post_translations', 'slug'),
            ],
            'content'                       => '',
            'additional'                    => 'nullable|array',
            'additional.template'           => [
                'required_if:type,page',
                'string',
                Rule::in(TemplateEnum::asArray()),
                'nullable',
            ],
            'additional.file_list_name'     => 'nullable',
            'additional.feature_posts'      => 'array',
            'additional.feature_posts.*.id' => 'required|exists:posts,id',
            'tags'                          => 'array',
            'tags.*.id'                     => 'nullable|exists:taxonomies,id',
            'tags.*.title'                  => 'required|string',
            'categories'                    => 'array',
            'categories.*.id'               => 'required|exists:taxonomies,id',
            'fileIds'                       => 'nullable|array|exists:files,id',
        ];
    }
}
