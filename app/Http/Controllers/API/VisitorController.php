<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateVisitorAction;
use App\Actions\DeleteVisitorAction;
use App\Actions\UpdateMultipleStatusVisitorAction;
use App\Actions\UpdateVisitorAction;
use App\Filters\VisitorFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVisitorRequest;
use App\Http\Requests\UpdateStatusMultipleVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Models\Visitor;
use App\Sorts\VisitorSort;
use App\Transformers\VisitorTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VisitorController extends Controller
{
    /**
     * VisitorController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Visitor::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\VisitorFilter $filter
     * @param \App\Sorts\VisitorSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, VisitorFilter $filter, VisitorSort $sort)
    {
        $visitors = Visitor::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($visitors, VisitorTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateVisitorRequest $request
     * @param \App\Actions\CreateVisitorAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateVisitorRequest $request, CreateVisitorAction $action)
    {
        $data = $request->validated();
        $visitor = $action->execute($data);

        return $this->httpCreated($visitor, VisitorTransformer::class);
    }

    /**
     * @param \App\Models\Visitor $visitor
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Visitor $visitor)
    {
        return $this->httpOK($visitor, VisitorTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateVisitorRequest $request
     * @param \App\Models\Visitor $visitor
     * @param \App\Actions\UpdateVisitorAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(UpdateVisitorRequest $request, Visitor $visitor, UpdateVisitorAction $action)
    {
        $data = $request->validated();
        $action->execute($data, $visitor, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Http\Requests\UpdateStatusMultipleVisitorRequest $request
     * @param \App\Actions\UpdateMultipleStatusVisitorAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function updateStatus(UpdateStatusMultipleVisitorRequest $request, UpdateMultipleStatusVisitorAction $action)
    {
        if (! Gate::allows('update-company-tour', auth()->user())) {
            return $this->httpForbidden();
        }
        $data = $request->validated();
        $action->execute($data, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Visitor $visitor
     * @param \App\Actions\DeleteVisitorAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \ReflectionException
     */
    public function destroy(Visitor $visitor, DeleteVisitorAction $action)
    {
        $action->execute($visitor);

        return $this->httpNoContent();
    }
}
