<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Get full information about the user.
     *
     * NOTE: Primary data after visiting the site.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(self::getFullInfoUser());
    }

    /**
     * Get full information about the user.
     *
     * @return array
     */
    public static function getFullInfoUser()
    {
        return [
            'user' => Auth::user(),
            'roles' => [],
        ];
    }
}
