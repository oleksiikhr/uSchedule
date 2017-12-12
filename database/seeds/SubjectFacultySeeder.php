<?php

use Illuminate\Database\Seeder;

class SubjectFacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\FacultySubject::class, 20)->create();
    }
}
