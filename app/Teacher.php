<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function subjects(){
        $this->hasMany(Subject::class);
    }
}
