<?php


namespace App\Actions;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateRoleAction {
    public function execute($data) {
        try {
            DB::beginTransaction();

            $roleData = Arr::except($data, 'permissions');
            $roleData['display_name'] = $roleData['name'] ;

            $role = Role::create($roleData);

            if ($permissionData = Arr::get($data, 'permissions')) {
                $role->syncPermissions($permissionData);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }

        return $role;
    }
}
