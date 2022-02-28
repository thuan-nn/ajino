<?php


namespace App\Actions;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateAdminAction {
    /**
     * @param $data
     * @param $admin
     *
     * @throws \Throwable
     */
    public function execute($data, $admin) {
        try {
            DB::beginTransaction();

            if (!$data['password']) {
                $data = Arr::except($data, 'password');
            }
            $admin->update(Arr::except($data, 'role_id'));
            $role_id = Arr::get($data, 'role_id');
            if ($role_id) {
                $admin->syncRoles($role_id);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new $exception;
        }
    }
}
