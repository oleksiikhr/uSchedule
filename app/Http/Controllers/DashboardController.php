<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;

class DashboardController extends WebController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard');
    }

    public function find(Request $request){
        $faculties = [
            'foais' => 1
        ];
        $schedule = Schedule::where([
            'degree' => $request->degree,
            'daytime' => $request->daytime,
            'course' => $request->course,
            'group_id' => $request->groups,
            'faculty_id' => $faculties[$request->faculty]])->firstOrFail();

        return $schedule->id;
    }
}
