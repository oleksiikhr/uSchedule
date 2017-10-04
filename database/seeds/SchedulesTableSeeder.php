<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Schedule::insert([
            'degree'     => 'bachelor',
            'daytime'    => 'daytime',
            'course'     => 1,
            'group_id'   => 1,
            'faculty_id' => 1,
        ]);
    }
}
