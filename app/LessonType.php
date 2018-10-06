<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonType extends Model
{
    public function lessonSubs()
    {
        return $this->hasMany(LessonSub::class);
    }
}
