<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class ClientInvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientIDs = [];
        $invoiceIDs = [];
        $totalClients = 0;

        // Seed the DB with clients
        do {
            $clientData = [
                'name' => str_random(15),
                'email' => str_random(15) . '@gmail.com',
                'apiKey' => Uuid::uuid4()->toString(),
            ];

            // Grab the client ID's for those that are inserted
            $clientIDs []= DB::table('clients')->insertGetId($clientData);
            $totalClients ++;
        } while ($totalClients < 10);

        // Loop through the client ID's to add invoices for each
        foreach ($clientIDs as $clientID) {
            $totalInvoices = 0;

            // Seed the invoice table with a random amount of invoices for each client
            do {
                $invoiceData = [
                    "clientID" => $clientID
                ];

                // Grab the invoice id's for each client invoice added
                $invoiceIDs []= DB::table('invoices')->insertGetId($invoiceData);
                $totalInvoices++;
            } while ($totalInvoices < ceil(rand(1,5)));
        }

        $currency = ['USD', 'EUR', 'JPY', 'GBP', 'AUD', 'CAD', 'CHF'];
        $totalLineItems = 0;

        // Loop through invoices to add lineitems for each
        foreach ($invoiceIDs as $invoiceID) {
            shuffle($currency);
            // Seed a random amount of line items for each invoice
            do {
                $invoiceLineItems = [
                    "invoiceID" => $invoiceID,
                    "name" => str_random(15),
                    "price" => number_format(rand(10, 10000), 2, '.', ''),
                    "currency" => $currency[0],
                    "quantity" => ceil(rand(1,100)),
                ];
                DB::table('lineItems')->insert($invoiceLineItems);
                $totalLineItems++;
            } while ($totalInvoices < ceil(rand(1,20)));

        }

        echo "Done Seeding" . PHP_EOL;
    }
}
