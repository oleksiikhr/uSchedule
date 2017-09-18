<?php

use Illuminate\Database\Seeder;

class ScheduleDayTeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\ScheduleDayTeacher::class, 60)->create();
    }
}
