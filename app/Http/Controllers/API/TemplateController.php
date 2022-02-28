<?php

namespace App\Http\Controllers\API;

use App\Enums\TemplateEnum;
use App\Http\Controllers\Controller;
use App\Transformers\TemplateTransformer;

class TemplateController extends Controller
{
    /**
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $templates = TemplateEnum::asArray();

        return $this->httpOK($templates, TemplateTransformer::class);
    }
}
