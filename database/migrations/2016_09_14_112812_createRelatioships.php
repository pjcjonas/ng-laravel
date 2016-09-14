<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatioships extends Migration
{
    /**
     * Run the migrations.
     * Generates the invoices table,
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('clientID')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::table('lineItems', function (Blueprint $table) {
            $table->foreign('invoiceID')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     * Drops the invoices table,
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function ($table) {
            $table->dropForeign('invoices_clientid_foreign');
        });

        Schema::table('lineItems', function ($table) {
            $table->dropForeign('lineitems_invoiceid_foreign');
        });
    }
}
