<?php

namespace Libraries\Api;

class ApiTables
{
    static $tables = [
        "clients" => [
            "columns" => [
                "name" => [
                    "type" => "string",
                    "required" => true
                ],
                "password" => [
                    "type" => "string",
                    "required" => true
                ],
            ],
        ],
        "invoices" => [
            "columns" => [
                "invoiceNumber" => [
                    "type" => "string",
                    "required" => true
                ],
                "invoiceDate" => [
                    "type" => "string",
                    "required" => true
                ],
            ],
        ],
        "lineItems" => [
            "columns" => [
                "name" => [
                    "type" => "string",
                    "required" => true
                ],
                "price" => [
                    "type" => "string",
                    "required" => true
                ],
                "quantity" => [
                    "type" => "string",
                    "required" => true
                ],
                "currency" => [
                    "type" => "string",
                    "required" => true
                ],
            ],
        ],
    ];
}
