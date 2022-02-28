<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppendMenuLinkRequest;
use App\Models\Menulink;

class NestedMenuLinkController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Menulink::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AppendMenuLinkRequest $appendMenuLinkRequest
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(AppendMenuLinkRequest $appendMenuLinkRequest)
    {
        $data = $appendMenuLinkRequest->validated();
        $menuParent = Menulink::query()->findOrFail($data['parent_id']);
        $menuChidren = Menulink::query()->findOrFail($data['children_id']);
        $menuChidren->appendOrPrependTo($menuParent, true)->save();

        return $this->httpNoContent();
    }
}
