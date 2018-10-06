<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
