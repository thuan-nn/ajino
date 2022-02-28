<?php

namespace App\Http\Controllers\API;

use App\Actions\CreateRoleAction;
use App\Actions\UpdateRoleAction;
use App\Filters\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Sorts\RoleSort;
use App\Transformers\RoleTransformer;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Role::class);
    }

    /**
     * @param Request $request
     * @param RoleFilter $filter
     * @param RoleSort $sort
     */
    public function index(Request $request, RoleFilter $filter, RoleSort $sort)
    {
        $roles = Role::query()->filter($filter)->sortBy($sort)->paginate($this->perPage);

        return $this->httpOK($roles, RoleTransformer::class);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @param CreateRoleAction $action
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function store(CreateRoleRequest $request, CreateRoleAction $action)
    {
        $data = $request->validated();
        $role = $action->execute($data);

        return $this->httpCreated($role);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return $this->httpOK($role, RoleTransformer::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param UpdateRoleAction $action
     * @param Role $role
     *
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, UpdateRoleAction $action, Role $role)
    {
        $data = $request->validated();
        $action->execute($role, $data);

        return $this->httpNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \App\Supports\Traits\SuccessResponseBuilder|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->httpNoContent();
    }
}
