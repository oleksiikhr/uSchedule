<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScheduleDay extends Model
{
    const DAYS = ['понеділок', 'вівторок', 'середа', 'четверг', 'п\'ятниця', 'субота'];

    protected $fillable = ['schedule_id', 'day', 'week', 'order', 'subject_id', 'is_empty', 'room', 'type'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teachers()
    {
        return $this->hasMany(ScheduleDayTeacher::class);
    }

    public function saveSchedule($schedule)
    {
        $weekNum = 0;
        foreach ($schedule as $week) {
            foreach ($week as $days) {
                if ($weekNum <= 1) {
                    foreach ($days as $dayNum => $day) {
                        foreach ($day as $order => $couple) {
                            try {
                                $match = self::updateOrCreate(
                                    ['schedule_id' => $couple['schedule_id'], 'day' => $dayNum, 'week' => $weekNum, 'order' => $order],
                                    [
                                        'subject_id' => $couple['is_empty'] == 1 ? 0 : $couple['subject']['id'],
                                        'is_empty' => $couple['is_empty'],
                                        'room' => $couple['room'],
                                        'type' => $couple['type'],
                                    ]
                                );
                                if ($couple['is_empty'] != 1) {
                                    ScheduleDayTeacher::saveTeachers($couple, $match->id);
                                }
                            }catch (\Exception $e){
                                throw new NotFoundHttpException($e);
                            }
                        }
                    }
                    $weekNum++;
                }
            }
        }
    }
}
