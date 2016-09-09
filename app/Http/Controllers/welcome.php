<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Welcome extends Controller
{

    private $data = [];

    /*
    * Welcome constructor
    */
    public function __construct()
    {
    }

    /**
     * Display the user registration process
     * @return view.pages.home
     */
    public function index()
    {
        $this->data['name'] = "Philip";
        return view('pages.home', $this->data);
    }
}
