<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function __construct()
    {
        $config = Config::select('value')
            ->where('name', '=', 'time')
            ->first();

        view()->share('time', json_encode(unserialize($config->value)));
    }
}
