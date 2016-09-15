<?php

namespace App\Http\Controllers;

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

        // Check if the password is sent
        $this->response = $this->validateAuth($data);
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

        $this->response = $this->valideData($data['data'], $data['method']);
        if (!empty($this->response['errors'])) {
            $this->response = $this->getErrorResponse('invalidData');
            echo json_encode($this->response);
            return;
        }


        if ($this->response['success']) {
            $this->dispatchEvent($data['method'], $data['data'], $this->response);
        }

        echo json_encode($this->response);

    }

    public function validateAuth($request)
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

        if (password_verify($request['password'], $client->password)) {
            $this->response['success'] = true; // FOUND
            $this->response['data']['clientID'] = $client->id;
        } else {
            $this->response['errors'] []= ApiErrors::$errors['invalidUsernamePassword']; // FAILED
        }

        return $this->response;
    }

    public function validateMethod($method)
    {
        return in_array($method, ApiMethods::$methods);
    }

    public function valideData($data, $method)
    {
        $crudTables = array_keys(ApiTables::$tables);
        $dataTables = array_keys($data);
        $this->response = [];
        switch ($method) {
            case "upsertInvoice":
                foreach ($dataTables as $dataTable) {
                    if (!in_array($dataTable, $crudTables)) {
                        $this->response = $this->getErrorResponse('invalidTable', $dataTable);
                    }
                }
            break;
        }

        /*
        Array
        (
            [invoice] => Array
                (
                    [number] => INV5433
                    [date] => 2015-01-01 14:21:53
                    [line_items] => Array
                        (
                            [0] => Array
                                (
                                    [name] => Keyboard
                                    [price] => 545.47
                                    [currency] => ZAR
                                    [quantity] => 3
                                )

                            [1] => Array
                                (
                                    [name] => Mouse
                                    [price] => 125.35
                                    [currency] => ZAR
                                    [quantity] => 3
                                )

                        )

                )

        )
        */

        return $this->response;
    }

    public function dispatchEvent($method, $request, $response)
    {
        echo "dispatchEvent";
    }

    public function formatData($response)
    {

    }

    public function getErrorResponse($error, $extra = null)
    {
        $this->response = ["success" => false, "errors" => [], "data" => []];
        $this->response['errors'] []= ApiErrors::$errors[$error];
        $this->response['success'] = false;
        return $this->response;
    }

}
