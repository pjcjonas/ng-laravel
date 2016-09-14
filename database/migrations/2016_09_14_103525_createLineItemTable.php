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
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(date('Y-m-d H:i:s'));
            $table->tinyInteger('deleted')->default(0);
        });

        DB::getPdo()->exec('
            CREATE TRIGGER lineItems_on_update BEFORE UPDATE ON lineItems FOR EACH ROW
            BEGIN
                SET new.updated_at := now();
            END;
        ');
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
