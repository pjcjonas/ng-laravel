<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class LoginController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Show the application login to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('login');
    }

}
