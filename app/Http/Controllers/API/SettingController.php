<?php

namespace App\Http\Controllers\API;

use App\Filters\SettingFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Sorts\SettingSort;
use App\Transformers\SettingTransformer;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * SettingController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Setting::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Filters\SettingFilter $filter
     * @param \App\Sorts\SettingSort $sort
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, SettingFilter $filter, SettingSort $sort)
    {
        $setting = Setting::query()->filter($filter)->sortBy($sort)->get();

        $settingTransformer = new SettingTransformer();

        return $this->httpOK($settingTransformer->transform($setting));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Http\Requests\CreateSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSettingRequest $request)
    {
        $data = $request->validated();

        foreach ($data as $item) {
            Setting::query()->updateOrCreate([
                'key' => $item['key'],
            ], $item
            );
        }

        return $this->httpNoContent();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Setting $setting)
    {
        return $this->httpOK($setting, SettingTransformer::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();

        foreach ($data as $item) {
            Setting::query()->updateOrCreate([
                'key' => $item['key'],
            ], $item
            );
        }

        return $this->httpNoContent();
    }

    /**
     * @param \App\Models\Setting $setting
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return $this->httpNoContent();
    }
}
