<?php

namespace App\Actions;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateAdminAction
{
    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function execute($data)
    {
        try {
            DB::beginTransaction();
            $role_id = Arr::get($data, 'role_id');
            $adminData = Arr::except($data, 'role_id');

            $admin = Admin::query()->create($adminData);

            $admin->syncRoles($role_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $admin;
    }
}
