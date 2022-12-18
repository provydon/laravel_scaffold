<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // AppSettings
            'settings_access',
            'settings_view',
            'settings_edit',
            // "settings_create",
            // "settings_delete",
            // "settings_restore",
            // "settings_force_delete",

            // Users
            'users_access',
            'users_create',
            'users_view',
            'users_edit',
            'users_delete',
            'users_approve_disapprove',
            'users_make_admin',
            'users_send_notification',

            // Access Control
            'access_control',
        ];

        foreach ($permissions as $key => $value) {
            $perm = new Permission();
            $perm->name = $value;
            $perm->guard_name = 'web';
            $perm->save();
        }
    }
}
