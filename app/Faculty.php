<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
