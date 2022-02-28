<?php

namespace App\Http\Controllers\API;

use App\Filters\LocationFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Location;
use App\Models\Setting;
use App\Sorts\LocationSort;
use App\Transformers\LocationTransformer;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class LocationController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\LocationFilter $filter
     * @param \App\Sorts\LocationSort $sort
     * @return \Flugg\Responder\Http\Responses\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, LocationFilter $filter, LocationSort $sort)
    {
        $location = Location::query()->filter($filter)->sortBy($sort)->get();

        return $this->httpOK($location, LocationTransformer::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Http\Requests\CreateLocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLocationRequest $request)
    {
        $data = $request->validated();

        foreach ($data as $item) {
            $locationId =  Arr::get($item, 'id');
            if (Arr::get($item, 'is_delete') && $locationId) {
                Location::find(Arr::get($item, 'id'))->delete();
                continue;
            }
            if ($locationId) {
                $location = Location::find($locationId);
                $location->fill($item);
            } else {
                $location = new Location(Arr::except($item, 'is_delete'));
            }
            $location->save();
        }

        return $this->httpNoContent();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Location $location)
    {
        return $this->httpOK($location, LocationTransformer::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateLocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateLocationRequest $request)
    {
        $data = $request->validated();

        foreach ($data as $item) {
            $locationId =  Arr::get($item, 'id');
            if (Arr::get($item, 'is_delete') && $locationId) {
                Location::find(Arr::get($item, 'id'))->delete();
                continue;
            }
            if ($locationId) {
                $location = Location::find($locationId);
                $location->fill($item);
            } else {
                $location = new Location(Arr::except($item, 'is_delete'));
            }
            $location->save();
        }

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Location $location
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return $this->httpNoContent();
    }
}
