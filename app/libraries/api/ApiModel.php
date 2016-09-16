<?php

namespace Libraries\Api;

use App\Clients;
use App\Invoices;
use App\LineItems;

class ApiModel
{
    /*
    |--------------------------------------------------------------------------
    | Api Models Library Class
    |--------------------------------------------------------------------------
    |
    | All api db calls will be made here in conjuciton with the
    | correct api calls
    */

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
    public static function getClientInvoiceByNumber($clientID, $invoiceNumber)
    {
        self::$invoicesModel = new Invoices();
        $client = self::$invoicesModel->where('clientID', $clientID)
            ->where('invoiceNumber', $invoiceNumber)
            ->get();
        return $client;
    }

    /**
     * Insert the invoice line items
     *
     * @var object
     */
    public static function insertInvoiceLineItems($lineItems)
    {
        self::$lineItemsModel = new LineItems();
        $status = self::$lineItemsModel->insert($lineItems);
        return $status;

    }

    /**
     * Insert new invoice
     *
     * @var object
     */
    public static function insertNewClientInvoice($clientID, $value)
    {
        self::$invoicesModel = new Invoices();

        self::$invoicesModel->invoiceNumber = $value['number'];
        self::$invoicesModel->clientID = $clientID;
        self::$invoicesModel->invoiceDate = $value['date'];

        self::$invoicesModel->save();

        return self::$invoicesModel->id;
    }

}
