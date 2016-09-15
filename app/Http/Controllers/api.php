<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Libraries\Api\ApiCore;
use Libraries\Api\ApiErrors;
use Libraries\Api\ApiMethods;
use Libraries\Api\ApiTables;
use Libraries\Api\ApiUtils;
use App\Clients;
use App\Invoices;
use App\LineItems;

class Api extends Controller
{

    private $clientsModel;
    private $invoicesModel;
    private $lineItemsModel;
    private $response = ["success" => false, "errors" => [], "data" => []];

    public function __construct()
    {
        $this->clientsModel = new Clients();
        $this->invoicesModel = new Invoices();
        $this->lineItemsModel = new LineItems();
    }

    public function index(Request $request)
    {
        $data = $request->all();
        $ip = $request->ip();
        // Check if the password is sent
        $this->response = $this->validateAuth($data, $ip);
        if (!empty($this->response['errors']) && !$this->response['success']) {
            echo json_encode($this->response);
            return;
        }

        // Validate that the correct API call is made
        if (empty($data['method']) || !$this->validateMethod($data['method'])) {
            $this->response = $this->getErrorResponse('invalidMethod');
            echo json_encode($this->response);
            return;
        }

        if (empty($data['data'])) {
            $this->response = $this->getErrorResponse('noData');
            echo json_encode($this->response);
            return;
        }

        $errors = $this->valideData($request, $data['method']);
        if (!empty($errors)) {
            $this->response = $this->getErrorResponse('invalidData', null, $errors);
            echo json_encode($this->response);
            return;
        }


        if ($this->response['success']) {
            $this->dispatchEvent($data['method'], $data['data'], $this->response);
        }

        echo json_encode($this->response);

    }

    public function validateAuth($request, $ip)
    {
        // Check to see if the email is passed
        if (empty($request['email'])) {
            $this->response['errors'] []= ApiErrors::$errors['noEmail'];
        }

        // Check if the password is passed
        if (empty($request['password'])) {
            $this->response['errors'] []= ApiErrors::$errors['noPassword'];
        }

        if ($this->response['errors']) {
            return $this->response;
        }

        // Validate User
        $client = $this->clientsModel->where('email', $request['email'])
            ->get()->first();

        if (empty($client)) {
            $this->response['errors'] []= ApiErrors::$errors['userNotFound'];
            return $this->response;
        }

        if (password_verify($request['password'], $client->password)) {
            if ($ip != $client->ip) {
                $this->response['errors'] []= ApiErrors::$errors['invalidLocation'];
            } else {
                $this->response['success'] = true; // FOUND
                $this->response['data']['clientID'] = $client->id;
            }
        } else {
            $this->response['errors'] []= ApiErrors::$errors['invalidUsernamePassword']; // FAILED
        }

        return $this->response;
    }

    public function validateMethod($method)
    {
        return in_array($method, ApiMethods::$methods);
    }

    public function valideData($request, $method)
    {
        $validator = Validator::make($request->all(), ApiTables::$tables[$method]["columns"]);
        $errors = $validator->errors()->all();
        return $errors;
    }

    public function dispatchEvent($method, $request, $response)
    {
        
    }

    public function formatData($response)
    {

    }

    public function getErrorResponse($error, $extra = null, $errors = [])
    {
        $this->response = ["success" => false, "errors" => [], "data" => []];
        $this->response['errors'] []= empty($errors) ? ApiErrors::$errors[$error] : $errors;
        $this->response['success'] = false;
        return $this->response;
    }

}
