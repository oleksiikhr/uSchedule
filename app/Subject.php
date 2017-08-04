<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
