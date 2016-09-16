<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Libraries\Api\ApiCore;
use Libraries\Api\ApiUtils;


class Api extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Api Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the entry point for all API calls and checks
    | authentication as well as validation of the data being sent to the
    | from a external source to submit and extract data form the app
    |
    */

    /**
     * Api controller entry point
     * All validation takes place here.
     * Echos out the json string with the status of the call and any errors.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $ip = $request->ip();

        // Check if the password is sent
        ApiUtils::$response = ApiUtils::validateAuth($data, $ip);
        if (!empty(ApiUtils::$response['errors']) && !ApiUtils::$response['success']) {
            echo json_encode(ApiUtils::$response);
            return;
        }

        // Validate that the correct API call is made
        if (empty($data['method']) || !ApiUtils::validateMethod($data['method'])) {
            ApiUtils::$response = ApiUtils::getErrorResponse('invalidMethod');
            echo json_encode(ApiUtils::$response);
            return;
        }

        // Check to see if the data object exists
        if (empty($data['data'])) {
            ApiUtils::$response = ApiUtils::getErrorResponse('noData');
            echo json_encode(ApiUtils::$response);
            return;
        }

        // Validate the API request data structure
        $errors = ApiUtils::valideData($request, $data['method']);
        if (!empty($errors)) {
            ApiUtils::$response = ApiUtils::getErrorResponse('invalidData', null, $errors);
            echo json_encode(ApiUtils::$response);
            return;
        }

        // everything passes, cal the dispatch event
        if (ApiUtils::$response['success']) {
            $this->dispatchEvent($data['method'], $data['data'], ApiUtils::$response);
        }

        // Output the json response
        echo json_encode(ApiUtils::$response);

    }

    /**
     * Api event dispatcher
     * After all validation passes the dispatcher sends the request to the API Model
     *
     * @return self:Array
     */
    public function dispatchEvent($method, $request, $response)
    {

    }

}
