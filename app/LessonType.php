<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonType extends Model
{
    protected $table = 'lesson_types';

    public function lessonSub()
    {
        return $this->hasMany(LessonSub::class);
    }
}
