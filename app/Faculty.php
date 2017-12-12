<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table = 'faculties';

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }
}
