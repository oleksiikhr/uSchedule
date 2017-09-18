<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    const DAYS = ['понеділок', 'вівторок', 'середа', 'четверг', 'п\'ятниця', 'субота'];

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

    public function saveSchedule($schedule){
        $weekNum = 0;
        foreach ($schedule as $week) {
            foreach ($week as $days) {
                if ($weekNum <= 1) {
                    foreach ($days as $dayNum => $day) {
                        foreach ($day as $order => $couple) {
                            $match = self::where('schedule_id', $couple['schedule_id'])
                                ->where('day', $dayNum)
                                ->where('week', $weekNum)
                                ->where('order', $order)
                                ->first();
                            if (isset($match)) {
                                $match->schedule_id = $couple['schedule_id'];
                                $match->subject_id = 0;
                                $match->teacher_id = 0;
                                $match->day = $dayNum;
                                $match->week = $weekNum;
                                $match->order = $order;

                                $this->isEmpty($match, $couple);

                                $match->is_empty = $couple['is_empty'];
                                $match->room = $couple['room'];
                                $match->type = $couple['type'];
                                $match->timestamps;
                                try{
                                    $match->save();
                                }catch (\Exception $e){
                                    echo $e;
                                }
                            } else {
                                $coupleDay = new ScheduleDay();
                                $coupleDay->schedule_id = $couple['schedule_id'];
                                $coupleDay->is_empty = $couple['is_empty'];
                                $coupleDay->teacher_id = 0;
                                $coupleDay->subject_id = 0;
                                $coupleDay->day = $dayNum;
                                $coupleDay->week = $weekNum;
                                $coupleDay->order = $order;

                                $this->isEmpty($coupleDay, $couple);

                                $coupleDay->room = $couple['room'];
                                $coupleDay->type = $couple['type'];
                                $coupleDay->timestamps;
                                try{
                                    $coupleDay->save();
                                }catch (\Exception $e){
                                    echo $e;
                                }

                            }
                        }
                    }
                    $weekNum++;
                }
            }
        }
    }

    private function isEmpty($object, $data): ScheduleDay
    {
        if($data['is_empty'] != 1) {
            try{
                $object->teacher_id = $data['teacher']['id'];
            }catch (\Exception $e){
                throw new \Exception('Вы не вказалы выкладача на ' . ($object->week + 1) . ' тиждні, ' . self::DAYS[$object->day] . ', ' . ($object->order + 1) . ' пара');
            }
            $object->subject_id = $data['subject']['id'];
        }

        return $object;
    }
}
