<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;

    public function subjects()
    {
        return $this->hasMany('App\TeacherSubject', 'id', 'teacher_id');
    }
}
