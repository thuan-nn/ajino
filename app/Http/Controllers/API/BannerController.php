<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateBannerAction;
use App\Actions\UpdateBannerAction;
use App\Filters\BannerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use App\Models\File;
use App\Sorts\BannerSort;
use App\Supports\Traits\PostBannerTrait;
use App\Transformers\BannerTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BannerController extends Controller
{
    use PostBannerTrait;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['localeCMS']);
        $this->authorizeResource(Banner::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\BannerFilter $filter
     * @param \App\Sorts\BannerSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, BannerFilter $filter, BannerSort $sort)
    {
        $banners = Banner::query()
                         ->filter($filter)
                         ->paginate($this->perPage);

        return $this->httpOK($banners, BannerTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateBannerRequest $createBannerRequest
     * @param \App\Actions\CreateBannerAction $createBannerAction
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateBannerRequest $createBannerRequest, CreateBannerAction $createBannerAction)
    {
        $data = $createBannerRequest->validated();

        $createBannerAction->execute($data, $this->locale);

        return $this->httpCreated();
    }

    /**
     * @param \App\Http\Requests\UpdateBannerRequest $createBannerRequest
     * @param \App\Models\Banner $banner
     * @param \App\Actions\UpdateBannerAction $updateBannerAction
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(
        UpdateBannerRequest $createBannerRequest,
        Banner $banner,
        UpdateBannerAction $updateBannerAction
    ) {
        $data = $createBannerRequest->validated();
        $updateBannerAction->execute($data, $banner, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Banner $banner
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Banner $banner)
    {
        $translation = $banner->translate($this->locale);

        if (is_null($translation)) {
            return $this->httpNotFound();
        }

        $banner->deleteTranslations($this->locale);

        if ($banner->translations->count() === 0) {
            $banner->delete();
        }

        $banner->items()->forceDelete();

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Banner $banner
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Banner $banner)
    {
        return $this->httpOK($banner, BannerTransformer::class);
    }

    /**
     * @param $fileIds
     * @return array|object
     */
    private function getImage($fileIds)
    {
        $file = File::query()->find($fileIds);
        if (is_null($file)) {
            return [];
        }

        return (object) Arr::only($file->toArray(), ['id', 'url', 'type']);
    }
}