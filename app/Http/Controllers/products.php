<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Products extends Controller
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
        return view('pages.products', $this->data);
    }
}
