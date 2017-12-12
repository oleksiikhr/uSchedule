<?php

use Illuminate\Database\Seeder;

class SubjectFacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * NOTE: See number in ExampleSeeder
     *
     * @return void
     */
    public function run()
    {
        factory(App\SubjectFaculty::class, 20)->create();
    }
}
