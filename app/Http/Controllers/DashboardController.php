<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Clients;
use App\Invoices;
use App\LineItems;
use App\Http\Requests;
use Validator;

class DashboardController extends Controller
{

    /**
     * Client model object
     *
     * @var object
     */
    public static $clientsModel;

    /**
     * Invoices model object
     *
     * @var object
     */
    public static $invoicesModel;

    /**
     * LineItems model object
     *
     * @var object
     */
    public static $lineItemsModel;

    /**
     * Get client invoice by number
     *
     * @var object
     */

    public function __construct()
    {
        self::$clientsModel = new Clients();
        self::$invoicesModel = new Invoices();
        self::$lineItemsModel = new LineItems();
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        // Get clients
        $clients = self::$clientsModel->orderby('id', 'desc')->get(["id", "name", "email", "updated_at"]);

        return view('dashboard', ['clients' => $clients]);
    }

    /**
     * Get client invoices.
     *
     * @return Response
     */
    public function postClientInvoices(Request $request)
    {
        $data = $request->all();

        $response = self::$invoicesModel->where(['clientID' => $data['clientID']])
            ->orderby('updated_at', 'desc')
            ->get();

        return response()->json($response->toArray());
    }

    /**
     * Get client invoice lineitems.
     *
     * @return Response
     */
    public function postClientLineItems(Request $request)
    {
        $data = $request->all();

        $response = self::$lineItemsModel->where(['invoiceID' => $data['invoiceID']])
            ->get();

        return response()->json($response->toArray());
    }

    /**
     * Post add client invoice.
     *
     * @return json Response
     */
    public function postAddInvoice(Request $request)
    {
        $data = $request->all();

        $response = self::$invoicesModel->limit(1)
            ->orderby('id', 'desc')
            ->get(['id']);
        $response = $response->toArray();
        $response = reset($response);

        $invoiceNumber = "INV" . str_pad(1, 8, '0', STR_PAD_LEFT);
        if (!empty($response['id'])) {
            $invoiceNumber = "INV" . str_pad((int)$response['id'] + 1, 8, '0', STR_PAD_LEFT);
        }

        $invoiceDate = date('Y-m-d H:i:s');
        self::$invoicesModel->clientID = $data['clientID'];
        self::$invoicesModel->invoiceNumber = $invoiceNumber;
        self::$invoicesModel->invoiceDate = $invoiceDate;
        self::$invoicesModel->save();

        $response = [
            'clientID' => $data['clientID'],
            'invoiceNumber' => $invoiceNumber,
            'invoiceDate' => $invoiceDate,
            'lastInsertId' => self::$invoicesModel->id,
        ];

        return response()->json($response);
    }

    /**
     * Post add client invoice lineitems.
     *
     * @return json Response
     */
    public function postAddLineItem(Request $request)
    {
        $data = $request->all();

        parse_str($data['data'], $data);

        $lineValidation = [
            "name" => "required|max:255",
            "price" => "required|numeric|min:0",
            "currency" => "required|max:3",
            "quantity" => "required|min:1",
        ];

        $validator = Validator::make($data, $lineValidation);
        $errors = $validator->errors();
        $invoiceLineItems = [];

        if (empty($errors->all())) {
            $invoiceLineItems = [
                "invoiceID" => $data['lineItemInvoiceID'],
                "name" => $data['name'],
                "price" => $data['price'],
                "currency" => $data['currency'],
                "quantity" => $data['quantity'],
            ];

            self::$lineItemsModel->invoiceID = $data['lineItemInvoiceID'];
            self::$lineItemsModel->name = $data['name'];
            self::$lineItemsModel->price = $data['price'];
            self::$lineItemsModel->currency = $data['currency'];
            self::$lineItemsModel->quantity = $data['quantity'];

            self::$lineItemsModel->save();
        }

        return response()->json([
            "status" => empty($errors->all()),
            "errors" => $errors,
            "lineitemID" => !self::$lineItemsModel->id ? false : $data['lineItemInvoiceID'],
            'data' => $invoiceLineItems,
            'date' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Post add new client.
     *
     * @return json Response
     */
    public function postAddClient(Request $request)
    {
        $data = $request->all();

        parse_str($data['data'], $data);

        $lineValidation = [
            "name" => "required|max:255",
            "password" => "required|min:8",
            "email" => "required|email|max:255",
        ];

        $validator = Validator::make($data, $lineValidation);
        $errors = $validator->errors();

        if (empty($errors->all())) {

            self::$clientsModel->name = $data['name'];
            self::$clientsModel->password = bcrypt($data['password']);
            self::$clientsModel->email = $data['email'];
            self::$clientsModel->description = $data['description'];
            self::$clientsModel->ip = $request->ip();

            self::$clientsModel->save();
        }

        return response()->json([
            "status" => empty($errors->all()),
            "errors" => $errors,
            'data' => ["name" => $data['name'], "id" => empty(self::$clientsModel->id) ? false : self::$clientsModel->id],
        ]);
    }
}
