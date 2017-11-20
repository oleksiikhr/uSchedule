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
        for ($i = 1; $i <= 30; $i++) {
            \App\ScheduleDayTeacher::insert([
                'schedule_day_id' => $i,
                'teacher_id' => mt_rand(1, 10),
            ]);
        }
    }
}
