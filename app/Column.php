<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $table = 'columns';

    public function days()
    {
        return $this->hasMany(Day::class);
    }
}
