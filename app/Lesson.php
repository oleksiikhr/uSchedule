<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function subs()
    {
        return $this->hasMany(LessonSub::class);
    }
}
