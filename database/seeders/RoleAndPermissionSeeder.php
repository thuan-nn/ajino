<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use App\Enums\UserType;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Role::truncate();
        Schema::enableForeignKeyConstraints();

        // Create permissions
        foreach (PermissionType::asArray() as $display_name => $name) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['name' => $name, 'guard_name' => 'admins', 'display_name' => Str::singular($display_name)]
            );
        }

        foreach (UserType::asArray() as $name) {
            Role::firstOrCreate(
                ['name' => $name],
                ['name' => $name, 'guard_name' => 'admins', 'display_name' => Str::ucfirst(str_replace('_', ' ', $name)),]
            );
        }

        // Give all permission to role super admin
        $superAdminRole = Role::findByName(UserType::SUPER_ADMIN, 'admins');
        $superAdminRole->syncPermissions(Permission::whereGuardName('admins')->get());

        $admin = Admin::where('name', 'admin')->first();
        $admin->assignRole($superAdminRole);
    }
}
