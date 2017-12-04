<?php

use App\ObjectType;
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
        ObjectType::insert([
            'name' => 'Университет',
            'slug' => 'university',
        ]);

        ObjectType::insert([
            'name' => 'Колледж',
            'slug' => 'college',
        ]);

        ObjectType::insert([
            'name' => 'Школа',
            'slug' => 'school',
        ]);
    }
}
