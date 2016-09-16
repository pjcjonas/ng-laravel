<?php

namespace Libraries\Api;

use Validator;
use Libraries\Api\ApiErrors;
use Libraries\Api\ApiMethods;
use Libraries\Api\ApiTables;
use App\Clients;
use App\Invoices;
use App\LineItems;

class ApiUtils
{

    /*
    |--------------------------------------------------------------------------
    | Api Utils Library Class
    |--------------------------------------------------------------------------
    |
    | Api Utils are a collection of API utilities that assist with validation
    | and authentication.
    |
    */

    /**
     * The validation response object
     *
     * @var array
     */
    public static $response = ["success" => false, "errors" => [], "data" => []];

    /**
     * Client model object
     *
     * @var object
     */
    private static $clientsModel;

    /**
     * Invoices model object
     *
     * @var object
     */
    private static $invoicesModel;

    /**
     * LineItems model object
     *
     * @var object
     */
    private static $lineItemsModel;


    /**
     * Returns the error response based on the failed status
     *
     * @return self::$response
     */
    public static function getErrorResponse($error, $extra = null, $errors = [])
    {
        self::$response = ["success" => false, "errors" => [], "data" => []];
        self::$response['errors'] []= empty($errors) ? ApiErrors::$errors[$error] : $errors;
        self::$response['success'] = false;
        return self::$response;
    }

    /**
     * Valide client api login credentials
     *
     * @return self::$response
     */
    public static function validateAuth($request, $ip)
    {
        if (empty($request['email'])) {
            self::$response['errors'] []= ApiErrors::$errors['noEmail'];
        }

        if (empty($request['password'])) {
            self::$response['errors'] []= ApiErrors::$errors['noPassword'];
        }

        if (self::$response['errors']) {
            return self::$response;
        }

        self::$clientsModel = new Clients();
        $client = self::$clientsModel->where('email', $request['email'])
            ->get()->first();

        if (empty($client)) {
            self::$response['errors'] []= ApiErrors::$errors['userNotFound'];
            return self::$response;
        }

        if (password_verify($request['password'], $client->password)) {
            if ($ip != $client->ip) {
                self::$response['errors'] []= ApiErrors::$errors['invalidLocation'];
            } else {
                self::$response['success'] = true;
                self::$response['data']['clientID'] = $client->id;
            }
        } else {
            self::$response['errors'] []= ApiErrors::$errors['invalidUsernamePassword'];
        }

        return self::$response;
    }

    /**
     * Validates the api request method
     *
     * @return self::$response
     */
    public static function validateMethod($method)
    {
        return in_array($method, ApiMethods::$methods);
    }

    /**
     * Validate the api request Data structure
     *
     * @return self::$response
     */
    public static function valideData($request, $method)
    {
        $validator = Validator::make($request->all(), ApiTables::$tables[$method]["columns"]);
        $errors = $validator->errors()->all();
        return $errors;
    }


}
