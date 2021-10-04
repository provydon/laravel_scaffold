<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create admins
        $new_user = User::factory()->create([
            'name' => 'Providence Ifeosame',
            'first_name' => 'Providence',
            'last_name' => 'Ifeosame',
            'is_admin' => true,
            'email' => 'providence@reftek.co',
            'password' => bcrypt('favour007')
        ]);

        $new_user->roles()->attach(1);


        $new_user = User::factory()->create([
            'name' => 'Micheal Owen',
            'first_name' => 'Micheal',
            'last_name' => 'Owen',
            'is_admin' => true,
            'email' => 'owen@reftek.co',
            'password' => bcrypt('favour007')
        ]);

        $new_user->roles()->attach(1);
    }
}
