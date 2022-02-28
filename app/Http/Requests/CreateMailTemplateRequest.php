<?php

namespace App\Http\Requests;

use App\Enums\LanguageEnum;
use App\Enums\MailTemplateType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMailTemplateRequest extends FormRequest
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
            'type'     => [
                'required',
                'string',
                Rule::in(MailTemplateType::asArray()),
                Rule::unique('mail_templates')->where(function ($query) {
                    $query->where(['type' => $this->get('type'), 'language' => $this->get('language')]);
                }),
            ],
            'title'    => 'required|string',
            'content'  => 'required|string',
            'language' => ['required', 'string', Rule::in(LanguageEnum::asArray())],
        ];
    }
}
