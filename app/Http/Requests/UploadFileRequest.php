<?php

namespace App\Http\Requests;

use App\Enums\FileTypeEnum;
use App\Enums\VisitorFileType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadFileRequest extends FormRequest
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
        $file = $this->type === FileTypeEnum::POST ? 512000 : 102400;
        return [
            'type'              => [
                'required',
                Rule::in(FileTypeEnum::asArray()),
            ],
            'visitor_file_type' => ['required_if:type,visitor', 'string', Rule::in(VisitorFileType::asArray())],
            'is_active'         => 'required_if:type,visitor',
            'files'             => 'required|array|max:20',
            'files.*'           => 'required|mimes:jpg,png,jpeg,doc,docx,pdf,csv,ico,svg,xlsx,xls|max:'.$file,
        ];
    }
}
