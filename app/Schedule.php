<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function days()
    {
        return $this->hasMany(Day::class);
    }
}
