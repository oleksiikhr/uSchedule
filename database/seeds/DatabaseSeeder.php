<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ObjectTypeSeeder::class);
        $this->call(DemoSeeder::class);
//        $this->call(UsersTableSeeder::class);
        $this->call(ObjectSeeder::class);
        $this->call(FacultySeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(TeacherSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(SubjectFacultySeeder::class);
    }
}
