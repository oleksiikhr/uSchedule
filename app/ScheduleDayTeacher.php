<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDayTeacher extends Model
{
    public function scheduleDay()
    {
        return $this->belongsTo(ScheduleDay::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
