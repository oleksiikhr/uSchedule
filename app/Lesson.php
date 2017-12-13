<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';

    public function subjectInfo()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
