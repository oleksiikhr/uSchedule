<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function scheduleDay()
    {
        return $this->hasMany(ScheduleDay::class);
    }
}
