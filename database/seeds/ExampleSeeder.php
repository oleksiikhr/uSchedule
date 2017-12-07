<?php

use App\Faculty;
use App\Group;
use App\Object;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Object::insert([
            'name' => 'Demo',
            'slug' => 'demo',
            'type_id' => 1,
            'image' => 'objects/demo/img/logo_200.png'
        ]);

        Faculty::insert([
            'object_id' => 1,
            'name' => 'ФОАІС',
            'description' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        Group::insert([
            'captain_id' => null,
            'faculty_id' => 1,
            'name' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        User::insert([
            'email'      => 'admin@example.com',
            'password'   => bcrypt('admin123'),
            'object_id'  => 1,
            'group_id'   => 1,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }
}
