<?php

use Illuminate\Database\Seeder;

class ObjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\ObjectType::insert([
            'name' => 'Университет',
            'slug' => 'university',
        ]);

        \App\ObjectType::insert([
            'name' => 'Коледж',
            'slug' => 'college',
        ]);

        \App\ObjectType::insert([
            'name' => 'Школа',
            'slug' => 'school',
        ]);
    }
}
