<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Teacher;
use App\Schedule;
use App\ScheduleDay;
use Illuminate\Http\Request;

class ScheduleController extends WebController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request as $week) {
            foreach ($week as $weekNum => $days) {
                /* Тут сохраняет, но возникает ошибка почему то - Invalid argument supplied for foreach() */
                foreach ($days as $dayNum => $day) {
                    foreach ($day as $order => $couple) {
                        $match = ScheduleDay::where('schedule_id', $couple['schedule_id'])
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
                            $match->timestamps;
                            if ($match->save()) {
                                echo 'OKs';
                            } else {
                                echo 'Ne ok';
                            }
                        } else {
                            $scheduleDay = new ScheduleDay();
                            $scheduleDay->schedule_id = $couple['schedule_id'];
                            $scheduleDay->subject_id = $couple['subject']['id'];
                            $scheduleDay->day = $dayNum;
                            $scheduleDay->week = $weekNum;
                            $scheduleDay->order = $order;
                            $scheduleDay->timestamps;
                            if ($scheduleDay->save()) {
                                echo 'OK';
                            } else {
                                echo 'Ne ok';
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);

        $scheduleDays = ScheduleDay::with('schedule', 'subject.teacher')
            ->where('schedule_id', $id)
            ->orderBy('week')
            ->orderBy('day')
            ->orderBy('order')
            ->get();

        $subjects = Subject::orderBy('title')
            ->where('faculty_id', $schedule->faculty_id)
            ->where('course', $schedule->course)
            ->get();

        return view('schedule.edit', [
            'scheduleDays' => $scheduleDays,
            'schedule'     => $schedule,
            'teachers'     => Teacher::get(), // TODO: Temporary get all teachers
            'subjects'     => $subjects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
