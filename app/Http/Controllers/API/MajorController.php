<?php

namespace App\Http\Controllers\API;

use App\Enums\MajorEnum;
use App\Http\Controllers\Controller;
use App\Transformers\MajorTransformer;

class MajorController extends Controller
{
    public function index()
    {
        $majors = MajorEnum::asSelectArray();

        return $this->httpOK($majors);
    }
}
