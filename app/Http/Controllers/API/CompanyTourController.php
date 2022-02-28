<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateCompanyTourAction;
use App\Actions\DeleteCompanyTourAction;
use App\Actions\UpdateCompanyTourAction;
use App\Filters\CompanyTourFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyTourRequest;
use App\Http\Requests\UpdateCompanyTourRequest;
use App\Models\CompanyTour;
use App\Sorts\CompanyTourSort;
use App\Transformers\CompanyTourTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyTourController extends Controller
{
    /**
     * CompanyTour constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(CompanyTour::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\CompanyTourFilter $filter
     * @param \App\Sorts\CompanyTourSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, CompanyTourFilter $filter, CompanyTourSort $sort)
    {
        $companyTours = CompanyTour::query()->filter($filter)->sortBy($sort)->get();

        return $this->httpOK($companyTours, CompanyTourTransformer::class);
    }

    /**
     * @param \App\Http\Requests\CreateCompanyTourRequest $request
     * @param \App\Actions\CreateCompanyTourAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(CreateCompanyTourRequest $request, CreateCompanyTourAction $action)
    {
        $data = $request->validated();

        $action->execute($data);

        return $this->httpCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\CompanyTour $companyTour
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(CompanyTour $companyTour)
    {
        return $this->httpOK($companyTour, CompanyTourTransformer::class);
    }

    /**
     * @param \App\Http\Requests\UpdateCompanyTourRequest $resquest
     * @param \App\Actions\UpdateCompanyTourAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function updateCompanyTour(UpdateCompanyTourRequest $resquest, UpdateCompanyTourAction $action)
    {
        if (! Gate::allows('update-company-tour', auth()->user())) {
            return $this->httpForbidden();
        }
        $data = $resquest->validated();
        $action->execute($data);

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\CompanyTour $companyTour
     * @param \App\Actions\DeleteCompanyTourAction $action
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(CompanyTour $companyTour, DeleteCompanyTourAction $action)
    {
        $action->execute($companyTour, $this->locale);

        return $this->httpNoContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\CompanyTourFilter $filter
     * @param \App\Sorts\CompanyTourSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function listCompanyTour(Request $request, CompanyTourFilter $filter, CompanyTourSort $sort)
    {
        $companyTours = CompanyTour::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($companyTours, CompanyTourTransformer::class);
    }
}
