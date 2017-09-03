<?php

use Illuminate\Database\Seeder;

class ScheduleDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\ScheduleDay::class, 30)->create();
    }
}
