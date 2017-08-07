<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
