<?php

namespace App\Http\Requests;

use App\Enums\BannerSlideTypeEnum;
use App\Enums\BannerType;
use App\Enums\PostTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBannerRequest extends FormRequest
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
            'post_id'                        => [
                'nullable',
                Rule::exists('posts', 'id')->where('type', PostTypeEnum::PAGE),
            ],
            'title'                          => 'string|nullable',
            'is_published'                   => 'boolean',
            'type_slide'                     => ['required', Rule::in(BannerSlideTypeEnum::asArray())],
            'additional.items'               => 'required|array',
            'additional.items.*.url'         => 'nullable|string',
            'additional.items.*.order'       => ['required', 'integer'],
            'additional.items.*.title'       => 'nullable|string',
            'additional.items.*.description' => 'nullable|string',
            'additional.items.*.type'        => ['required', Rule::in(BannerType::asArray())],
            'additional.items.*.video_url'   => [
                'nullable',
                'required_if:items.*.type,'.BannerType::VIDEO,
                'string',
            ],
            'additional.items.*.images'      => 'nullable|array',
            'additional.items.*.images.*.id' => 'string|exists:files,id',
        ];
    }
}
