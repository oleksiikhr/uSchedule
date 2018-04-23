<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;

    public function subjects()
    {
        return $this->hasMany('App\TeacherSubject', 'id', 'subject_id');
    }
}
