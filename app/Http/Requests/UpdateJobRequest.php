<?php

namespace App\Http\Requests;

use App\Enums\FileTypeEnum;
use App\Models\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpdateJobRequest extends FormRequest
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
            'order'                     => 'nullable|numeric',
            'is_published'              => 'boolean',
            'location_id'               => 'filled|exists:locations,id',
            'title'                     => 'filled|string',
            'description'               => 'filled|string',
            'job_type'                  => 'filled|string',
            'salary'                    => 'nullable|array',
            'salary.from'               => 'nullable|numeric',
            'salary.to'                 => 'nullable|numeric|gt:salary.from',
            'slug'                      => [
                'nullable',
                'string',
                Rule::unique('taxonomy_translations', 'slug'),
                Rule::unique('post_translations', 'slug'),
            ],
            'additional'                => 'nullable|array',
            'taxonomyIds'               => 'nullable|array|exists:taxonomies,id',
            'fileIds'                   => 'nullable|array|exists:files,id',
        ];
    }
}
