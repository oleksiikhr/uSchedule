<?php

use Illuminate\Database\Seeder;

class FacultyTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\FacultyTeacher::class, 20)->create();
    }
}
