<?php

namespace App\Http\Controllers\API;

use App\Filters\PermissionFilter;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Sorts\PermissionSort;
use App\Transformers\PermissionTransformer;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->authorizeResource(Permission::class);
    }

    public function index(Request $request, PermissionFilter $filter, PermissionSort $sort)
    {
        $permissions = Permission::query()
                                 ->filter($filter)
                                 ->sortBy($sort)
                                 ->paginate($this->perPage);

        return $this->httpOK($permissions, PermissionTransformer::class);
    }
}
