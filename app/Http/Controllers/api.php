<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Libraries\Api\ApiCore;

class Api extends Controller
{

    public function __construct()
    {

    }

    public function index($secretID = null, $accountID = null)
    {
        if (!empty($secretID) && !empty($accountID)) {
            $this->validateTokens($secretID, $accountID);
        }
    }

    public function validateTokens($secretID, $accountID)
    {

    }

    public function dispatchEvent()
    {

    }

    public function formatData($response)
    {

    }

}
