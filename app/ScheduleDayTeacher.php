<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDayTeacher extends Model
{
    public $timestamps = false;

    public function scheduleDay()
    {
        return $this->belongsTo(ScheduleDay::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public static function saveTeachers($data, $id)
    {
        foreach ($data['teachers'] as $teacher){
            $sdt = self::where([
                'schedule_day_id' => $id,
                'teacher_id' => $teacher['teacher']['id']]
            )->first();

            if ($sdt) {
                if ($teacher['teacher']['id'] != $sdt->teacher_id) {
                    $sdt->teacher_id = $teacher['teacher']['id'];
                    $sdt->save();
                }
            } else {
                $sdtN = new ScheduleDayTeacher();
                $sdtN->schedule_day_id = $id;
                $sdtN->teacher_id = $teacher['teacher']['id'];
                $sdtN->timestamps; // TODO: see*
                $sdtN->save();
            }
        }
    }
}
