<?php

namespace App\Http\Controllers;

use App\Faculty;
use App\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\TeacherRequest;

class TeacherController extends Controller
{
    /**
     * Get all teachers
     *
     * @param TeacherRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(TeacherRequest $request)
    {
        $teachers = Teacher::whereHas('faculty', function ($q) use ($request) {
            $q->where('faculty_id', $request->faculty_id);
        })
            ->get();

        return $teachers;
    }

    /**
     * Get one teacher
     *
     * @param  Request $request
     */
    public function one(Request $request)
    {
        // TODO: Implement one() method.
    }

    /**
     * Create new teacher
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update existing teacher by id
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete teacher by id
     *
     * @param  Request $request
     */
    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }

}