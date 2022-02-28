<?php

namespace App\Http\Controllers\API;

use App\Actions\UpdateVisitorFileSettingAction;
use App\Filters\VisitorFileSettingFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateVisitorFileSettingRequest;
use App\Models\VisitorFileSetting;
use App\Sorts\VisitorFileSettingSort;
use App\Transformers\VisitorFileSettingTransformer;
use Illuminate\Http\Request;

class VisitorFileSettingController extends Controller
{
    /**
     * VisitorFileSettingController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(VisitorFileSetting::class);
    }


    public function index(Request $request, VisitorFileSettingFilter $filter, VisitorFileSettingSort $sort)
    {
        $visitorFileSetting = VisitorFileSetting::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($visitorFileSetting, VisitorFileSettingTransformer::class);
    }

    /**
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(VisitorFileSetting $visitorFileSetting)
    {
        return $this->httpOK($visitorFileSetting, VisitorFileSettingTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateVisitorFileSettingRequest $request
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @param \App\Actions\UpdateVisitorFileSettingAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function update(
        UpdateVisitorFileSettingRequest $request,
        VisitorFileSetting $visitorFileSetting,
        UpdateVisitorFileSettingAction $action
    ) {
        $data = $request->validated();
        $action->execute($data, $visitorFileSetting);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\VisitorFileSetting $visitorFileSetting
     * @throws \Exception
     */
    public function destroy(VisitorFileSetting $visitorFileSetting)
    {
        $visitorFileSetting->delete();

        return $this->httpNoContent();
    }
}
