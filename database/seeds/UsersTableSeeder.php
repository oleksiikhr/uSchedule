<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->first_name = 'Admin';
        $user->middle_name = '';
        $user->last_name = '';
        $user->email = 'admin@uschedule.com';
        $user->password = bcrypt('admin123');
        $user->is_admin = 1;
        $user->save();
    }
}
