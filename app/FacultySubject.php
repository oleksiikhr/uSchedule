<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FacultySubject extends Pivot
{
    protected $table = 'faculty_subject';

    public $timestamps = false;
}