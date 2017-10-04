<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function scheduleDay()
    {
        return $this->hasMany(ScheduleDay::class);
    }

    public function facultyId()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public static function subjectExist($id)
    {
        return self::where('id', $id)->exists();
    }
}
