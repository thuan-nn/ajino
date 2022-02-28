<?php

namespace App\Http\Controllers\API;

use App\Enums\PostTypeEnum;
use App\Http\Controllers\Controller;

class PostTypeController extends Controller
{
    public function index()
    {
        $postType = PostTypeEnum::asArray();

        return $this->httpOK($postType);
    }
}
