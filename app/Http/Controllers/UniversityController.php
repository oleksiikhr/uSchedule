<?php
/**
 * Created by PhpStorm.
 * User: Acer
 * Date: 09.09.2017
 * Time: 13:19
 */

namespace App\Http\Controllers;


class UniversityController extends WebController
{

    public function index(){
        return view('university.main');
    }

}