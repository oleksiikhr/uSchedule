<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $table = 'days';

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->with('subjectInfo');
    }
}
