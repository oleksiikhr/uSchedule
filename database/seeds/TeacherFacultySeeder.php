<?php

use Illuminate\Database\Seeder;

class TeacherFacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TeacherFaculty::class, 20)->create();
    }
}
