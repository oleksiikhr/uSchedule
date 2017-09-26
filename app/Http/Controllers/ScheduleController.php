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
     * TODO: compare methods
     * @see store
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function storeNew(Request $request, $id)
    {
        Schedule::where('id', '=', $id)->firstOrFail();
        $data = $request->all();

        // TODO: temporary count array 2 [1 and 2 week]
        if (!is_array($data) && count($data) != 2) {
            return response()->json(['errors' => ['The array must be count 2']]); // TODO: text english
        }

        $this->validate($request, [
            '*' => 'required|array|size:6', // TODO: Temporary size 6
            '*.*.*.subject.id' => 'sometimes|exists:subjects,id', // TODO: if (is_empty != 0) => required field
            '*.*.*.teachers.teacher_id' => 'sometimes|exists:teachers.id', // TODO: if (is_empty != 0) => required field
            '*.*.*.is_empty' => 'required|boolean',
            '*.*.*.type' => 'numeric|between:0,3', // TODO: temporary max. if (is_empty != 0) => required field
            '*.*.*.room' => 'between:0,10',
        ]);

        foreach ($data as $weekNum => $week) {
            foreach ($week as $dayNum => $days) {
                foreach ($days as $order => $item) {
                    // TODO: problem with save [index*]

                    $scheduleDay = ScheduleDay::where('schedule_id', '=', $id)
                        ->where('week', '=', $weekNum)
                        ->where('day', '=', $dayNum)
                        ->where('order', '=', $order)
                        ->first();

                    $arr = [
                        'subject_id' => $item['subject']['id'],
                        'schedule_id' => $id,
                        'week' => $weekNum,
                        'day' => $dayNum,
                        'order' => $order,
                        'room' => $item['room'],
                        'is_empty' => $item['is_empty'],
                        'type' => $item['is_empty'] ? 0 : $item['type']
                    ];

                    if ($scheduleDay) {
                        ScheduleDay::where('id', '=', $scheduleDay->id)->update($arr);
                    } else {
                        ScheduleDay::insert($arr);
                    }

                    // TODO: update teachers
                }
            }
        }
    }

    /**
     * TODO: Temporary method
     * @see storeNew
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new ScheduleDay();
        $schedule->saveSchedule($request);
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

        $scheduleDays = ScheduleDay::with('schedule', 'subject', 'teachers.teacher')
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
            'daysWeek'     => ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            'types'        => [['Л', 'Лекція'], ['П', 'Практика'], ['Лб1', 'Лабораторна робота 1'],
                ['Лб2', 'Лабораторна робота 2']],
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
