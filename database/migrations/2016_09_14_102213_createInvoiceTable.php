<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     * Generates the invoices table,
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('clientID')->unsigned();
            $table->string('invoiceNumber');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(date('Y-m-d H:i:s'));
            $table->tinyInteger('deleted')->default(0);
        });

        DB::getPdo()->exec('
            CREATE TRIGGER invoicess_on_update BEFORE UPDATE ON invoices FOR EACH ROW
            BEGIN
                SET new.updated_at := now();
            END;
        ');

    }

    /**
     * Reverse the migrations.
     * Drops the invoices table,
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}
