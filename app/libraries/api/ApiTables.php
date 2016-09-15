<?php

namespace Libraries\Api;

class ApiTables
{
    static $tables = [
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
