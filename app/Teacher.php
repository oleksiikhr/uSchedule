<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function scheduleDay()
    {
        return $this->hasMany(ScheduleDay::class);
    }
}
