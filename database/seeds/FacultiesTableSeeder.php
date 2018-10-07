<?php

use Illuminate\Database\Seeder;

class FacultiesTableSeeder extends Seeder
{
    const COUNT = 6;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = [
            'Faculty of Economics, Management and Psychology',
            'Faculty of Accounting, Auditing and Information Systems',
            'Faculty of Restaurant, Hotel and Tourism Business',
            'Faculty of Trade and Marketing',
            'Faculty of Finance and Banking',
            'Faculty of International Trade and Law',
        ];

        foreach ($faculties as $faculty) {
            $model = new \App\Faculty();
            $model->name = $faculty;
            $model->save();
        }
    }
}
