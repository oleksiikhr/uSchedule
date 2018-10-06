<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function lessonSub()
    {
        return $this->hasMany(LessonSub::class);
    }
}
