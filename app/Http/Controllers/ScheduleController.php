<?php

namespace App\Http\Controllers;

use App\Schedule;
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
        // TODO: Implement list() method.
    }

    /**
     * Get one schedule
     *
     * @param integer $id Schedule
     * @param ScheduleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function one($id, ScheduleRequest $request)
    {
        // TODO: Temporary

        return response()->json(Schedule::findOrFail($id));
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