<?php

namespace App\Http\Controllers;

use App\ObjectLessonTime;
use Illuminate\Http\Request;

class ObjectLessonTimesController extends Controller
{
	/**
	 * Get all schedules with pagination
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function list(Request $request)
	{
		// TODO: Temporary
		// TODO: Need validate, orderBy, etc.
		return response()->json(ObjectLessonTime::where('object_id', $request->object_id)->get());
	}
}
