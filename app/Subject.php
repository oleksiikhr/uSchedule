<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    const PER_PAGE = 20;

    public $timestamps = false;

    public function subjects()
    {
        return $this->hasMany('App\TeacherSubject', 'id', 'subject_id');
    }

    public static function getSubjects()
    {
        return self::paginate(self::PER_PAGE);
    }
}
