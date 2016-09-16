<?php

namespace Libraries\Api;

class ApiTables
{

    /*
    |--------------------------------------------------------------------------
    | Api Tables Library Class
    |--------------------------------------------------------------------------
    |
    | Api tables class contains a tables array that is used to validate data
    | strectures to make sure that the api structure is the as it should
    | using the laravel Validator Library
    |
    */

    /**
     * Table list with columns used for validation
     *
     * @var static array
     */
    public static $tables = [
        "upsertInvoice" => [
            "columns" => [
                "data" => "required|array|min:1",
                "data.invoice" => "required|array|min:1",
                "data.invoice.*.number" => "required|max:255",
                "data.invoice.*.date" => "required|max:255",
                "data.invoice.*.line_items" => "required|array|min:1",
                "data.invoice.*.line_items.*.name" => "required|max:255",
                "data.invoice.*.line_items.*.price" => "required|numeric|min:0",
                "data.invoice.*.line_items.*.currency" => "required|max:3",
                "data.invoice.*.line_items.*.quantity" => "required|min:1",
            ],
        ],
    ];
}
