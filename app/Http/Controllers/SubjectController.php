<?php

namespace App\Http\Controllers;

use App\Faculty;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectRequest;

class SubjectController extends Controller
{
    /**
     * Get list of subjects
     *
     * @param SubjectRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(SubjectRequest $request)
    {
        $subjects = Faculty::find($request->faculty_id)->subjects()->get();

        return $subjects;
    }

    /**
     * Get one subject
     *
     * @param  Request $request
     */
    public function one(Request $request)
    {
        // TODO: Implement one() method.
    }

    /**
     * Create new subject
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    /**
     * Update existing subject by id
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * Delete subject by id
     *
     * @param  Request $request
     */
    public function delete(Request $request)
    {
        // TODO: Implement delete() method.
    }
}