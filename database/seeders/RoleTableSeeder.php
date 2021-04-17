<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            "Super Admin"
        ];

        foreach ($roles as $key => $value) {
            $role = new Role();
            $role->name = $value;
            $role->guard_name = "web";
            $role->save();

            $perms = Permission::count();

            for ($i = 1; $i <= $perms; $i++) {
                $role->permissions()->attach($i);
            }
        }
    }
}
