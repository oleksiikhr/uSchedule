<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    public $timestamps = false;

    public function teacher() {
        return $this->hasOne('App\Teacher', 'id', 'teacher_id');
    }

    public function subject() {
        return $this->hasOne('App\Subject', 'id', 'subject_id');
    }
}
