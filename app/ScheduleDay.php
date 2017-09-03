<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function saveSchedule($schedule){
        foreach ($schedule as $week) {
            foreach ($week as $weekNum => $days) {
                if(is_string($weekNum)){
                    break;
                }
                foreach ($days as $dayNum => $day) {
                    foreach ($day as $order => $couple) {
                        $match = self::where('schedule_id', $couple['schedule_id'])
                            ->where('day', $dayNum)
                            ->where('week', $weekNum)
                            ->where('order', $order)
                            ->first();
                        if (isset($match)) {
                            $match->schedule_id = $couple['schedule_id'];
                            $match->subject_id = $couple['subject']['id'];
                            $match->day = $dayNum;
                            $match->week = $weekNum;
                            $match->order = $order;
                            $match->room = $couple['room'];
                            $match->timestamps;
                            $match->save();
                        } else {
                            $this->schedule_id = $couple['schedule_id'];
                            $this->subject_id = $couple['subject']['id'];
                            $this->day = $dayNum;
                            $this->week = $weekNum;
                            $this->order = $order;
                            $this->room = $couple['room'];
                            $this->timestamps;
                            $this->save();
                        }
                    }
                }
            }
        }

    }
}
