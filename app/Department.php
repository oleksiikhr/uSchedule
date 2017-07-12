<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function faculty()
    {
        $this->belongsTo(Faculty::class);
    }
}
