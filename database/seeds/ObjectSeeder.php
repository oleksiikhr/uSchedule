<?php

use App\ObjectModel;
use Illuminate\Database\Seeder;

class ObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ObjectModel::class, 5)->create();
    }
}
