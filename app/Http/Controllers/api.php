<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Libraries\Api\ApiCore;
use App\Clients;

class Api extends Controller
{

    public $clientsModel;

    public function __construct()
    {
        $this->clientsModel = new Clients();
    }

    public function index()
    {
        echo "AWE";
    }

    public function validateTokens($apiKey)
    {

    }

    public function dispatchEvent()
    {

    }

    public function formatData($response)
    {

    }

}
