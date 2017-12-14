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
}
