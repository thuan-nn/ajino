<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachTaxonomiesPostRequest;
use App\Models\Post;
use Illuminate\Support\Arr;

class PostTaxonomiesController extends Controller
{
    /**
     * @param \App\Http\Requests\AttachTaxonomiesPostRequest $request
     * @param \App\Models\Post $post
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(AttachTaxonomiesPostRequest $request, Post $post)
    {
        $data = $request->validated();

        $taxonomyIds = Arr::get($data, 'taxonomyIds');

        $post->taxonomies()->sync($taxonomyIds);

        return $this->httpCreated();
    }
}
