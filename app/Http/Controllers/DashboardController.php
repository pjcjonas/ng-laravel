<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Clients;
use App\Invoices;
use App\LineItems;
use App\Http\Requests;

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
        $clients = self::$clientsModel->get(["id", "name", "email", "updated_at"]);

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

}
