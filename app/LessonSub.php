<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonSub extends Model
{
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function type()
    {
        return $this->belongsTo(LessonType::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
