<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonSub extends Model
{
    protected $table = 'lesson_subs';

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function type()
    {
        return $this->belongsTo(LessonType::class);
    }
}
