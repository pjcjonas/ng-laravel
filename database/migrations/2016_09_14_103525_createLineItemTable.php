<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineItemTable extends Migration
{
    /**
     * Run the migrations.
     * Generates the lineItems table,
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('lineItems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('invoiceID')->unsigned();
            $table->string('name');
            $table->decimal('price', 11, 2);
            $table->string('currency');
            $table->integer('quantity');
            $table->timestamps();
            $table->tinyInteger('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     * Drops the lineItems table,
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lineItems');
    }
}
