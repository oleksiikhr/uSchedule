<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    const PER_PAGE = 20;

    public $timestamps = false;

    public function subjects()
    {
        return $this->hasMany('App\TeacherSubject', 'id', 'teacher_id');
    }

    public function getImageAttribute () {
        if (! $this->attributes['image']) {
            return url('/') . '/images/avatar.png';
        }

        return $this->attributes['image'];
    }

    public static function getTeachers()
    {
        return self::paginate(self::PER_PAGE);
    }
}
