<?php

namespace App\Http\Controllers;

use App\ObjectType;
use Illuminate\Http\Request;

class ObjectTypeController extends Controller
{
    /**
     * Get all types.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        // TODO: Temporary
        $schedule = ObjectType::where('id', $request->schedule_id)->get();

        return response()->json($schedule);
    }
}
