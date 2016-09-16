<?php

namespace Libraries\Api;

use Libraries\Api\ApiModel;

class ApiCore
{

    /*
    |--------------------------------------------------------------------------
    | Api ApiCore Library Class
    |--------------------------------------------------------------------------
    |
    | Api request methods that will tie into the APIModel
    |
    */

    public static function upsertInvoice($request, $clientID)
    {
        $lineItems = [];
        $invoiceID = null;
        foreach ($request['invoice'] as $key => $value) {
            // Check if the client invoice exists
            $invoice = ApiModel::getClientInvoiceByNumber($clientID, $value['number']);

            // Check to see if there is a invoice for clientID
            if ($invoice->count()) {
                // get the ID of the exisitng invoice
                $invoiceID = $invoice->first()->id;
            } else {
                // Insert Invoice and get its ID
                $invoiceID = ApiModel::insertNewClientInvoice($clientID, $value);
            }

            // Update invoice Line Items
            if (!empty($value['line_items'])) {
                $i = 0;
                foreach ($value['line_items'] as $line) {
                    $value['line_items'][$i]['invoiceID'] = $invoiceID;
                    $lineItems []= $value['line_items'][$i];
                    $i++;
                }
            }
        }

        // Insert the line items associated to the invoice
        $insertStatus = ApiModel::insertInvoiceLineItems($lineItems);
    }

}
