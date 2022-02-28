<?php

namespace App\Http\Controllers\API;

use App\Filters\MenuFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Models\Menu;
use App\Sorts\MenuSort;
use App\Transformers\MenuTransformer;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * MenuController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Menu::class);
    }

    /**
     * @param Request $request
     * @param MenuFilter $filter
     * @param MenuSort $sort
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request, MenuFilter $filter, MenuSort $sort)
    {
        $menus = Menu::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($menus, MenuTransformer::class);
    }

    /**
     * @param CreateMenuRequest $createMenuRequest
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(CreateMenuRequest $createMenuRequest)
    {
        $data = $createMenuRequest->validated();
        $menu = Menu::query()->create($data);

        return $this->httpCreated($menu, MenuTransformer::class);
    }

    /**
     * @param Menu $menu
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Menu $menu)
    {
        return $this->httpOK($menu, MenuTransformer::class);
    }

    /**
     * @param UpdateMenuRequest $updateMenuRequest
     * @param Menu $menu
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateMenuRequest $updateMenuRequest, Menu $menu)
    {
        $data = $updateMenuRequest->validated();
        $menu->update($data);

        return $this->httpNoContent();
    }

    /**
     * @param Menu $menu
     */
    public function destroy(Menu $menu)
    {
        $menu->menulinks()->whereTranslation('locale', $this->locale)->delete();

        return $this->httpOK();
    }
}
