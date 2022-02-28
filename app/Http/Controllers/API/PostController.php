<?php

namespace App\Http\Controllers\API;

use App\Actions\CreatePostAction;
use App\Actions\DeletePostAction;
use App\Actions\UpdatePostAction;
use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Sorts\PostSort;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * PostController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Post::class);
        $this->middleware(['localeCMS']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\PostFilter $filter
     * @param \App\Sorts\PostSort $sort
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, PostFilter $filter, PostSort $sort)
    {
        $posts = Post::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($posts, PostTransformer::class);
    }

    /**
     * @param CreatePostRequest $createPostRequest
     * @param CreatePostAction $createPostAction
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreatePostRequest $createPostRequest, CreatePostAction $createPostAction)
    {
        $data = $createPostRequest->validated();

        $post = $createPostAction->execute($data, $this->locale);

        return $this->httpCreated($post, PostTransformer::class);
    }

    /**
     * @param \App\Models\Post $post
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return $this->httpOK($post, PostTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Actions\UpdatePostAction $updatePostAction
     * @param \App\Models\Post $post
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdatePostRequest $request, UpdatePostAction $updatePostAction, Post $post)
    {
        $data = $request->validated();
        $updatePostAction->execute($data, $post, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Post $post
     * @param \App\Actions\DeletePostAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \HttpException
     */
    public function destroy(Post $post, DeletePostAction $action)
    {
        $translation = $post->translate($this->locale);

        if (is_null($translation)) {
            return $this->httpNotFound();
        }

        $action->execute($post, $this->locale);

        return $this->httpNoContent();
    }
}
