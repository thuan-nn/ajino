<?php

namespace App\Http\Controllers\API;

use App\Filters\CompanyTourFilter;
use App\Http\Controllers\Controller;
use App\Models\CompanyTour;
use App\Models\Location;
use App\Sorts\CompanyTourSort;
use App\Transformers\CompanyTourUserTransformer;
use App\Transformers\LocationUiTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyTourUserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\CompanyTourFilter $filter
     * @param \App\Sorts\CompanyTourSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, CompanyTourFilter $filter, CompanyTourSort $sort)
    {
        $companyTours = CompanyTour::query()
                                   ->isCancel()
                                   ->dateApproveCompany()
                                   ->fullSlotVisit()
                                   ->filter($filter)
                                   ->sortBy($sort)
                                   ->get()
                                   ->reject(function ($value) {
                                       $date = Carbon::createFromDate($value->date);

                                       return ! $date->isWeekday();
                                   });

        return $this->httpOK($companyTours, CompanyTourUserTransformer::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $location_id
     * @return mixed
     */
    public function locationContent(Request $request, $location_id)
    {
        $location = Location::query()->where('id', $location_id)->first();
        
        return $this->httpOK($location, LocationUiTransformer::class);
    }
}
