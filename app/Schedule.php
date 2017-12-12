<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';

    public function columns()
    {
        return $this->hasMany(Column::class);
    }
}
