<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Super admin'],
            ['name' => 'object-owner', 'display_name' => 'Owner', 'description' => 'User which registered object'],
            ['name' => 'student', 'display_name' => 'Student', 'description' => 'Default user']
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'description' => $role['description']
            ]);
        }

        $user = \App\User::find(1);
        $user->attachRole(1);
    }
}
