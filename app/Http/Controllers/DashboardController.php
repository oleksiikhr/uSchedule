<?php

namespace App\Http\Controllers;

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
}
