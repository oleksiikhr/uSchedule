<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FacultyTeacher extends Pivot
{
    protected $table = 'faculty_teacher';

    public $timestamps = false;
}
