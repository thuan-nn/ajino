<?php


namespace App\Actions;


use App\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction {
    public function execute(Role $role, $data) {
        try {
            DB::beginTransaction();
            $roleData = Arr::except($data, 'permissions');
            $roleData['display_name'] = $roleData['name'] ;

            $role->update($roleData);

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
