<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\ScheduleDay;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;

class ScheduleController extends Controller
{
    const ITEMS_PER_PAGE = 25;

    /**
     * Get all schedules with pagination
     *
     * @param ScheduleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ScheduleRequest $request)
    {
        // TODO: Temporary
    }

    /**
     * Get one schedule
     *
     * @param ScheduleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function one(ScheduleRequest $request)
    {
        // TODO: Temporary
        $schedule = Schedule::with([
        	'columns.days.lessons.subjectInfo',
	        'columns.days.lessons.subs.teacher',
	        'columns.days.lessons.subs.type'
        ])
            ->where('id', '=', $request->schedule_id)
            ->firstOrFail();

        return response($schedule);
    }

    /**
     * Create new schedule
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update existing schedule by id
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete schedule by id
     *
     * @param  Request $request
     */
    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }
}