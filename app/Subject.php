<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function teacher(){
        $this->belongsTo(Teacher::class);
    }
}
