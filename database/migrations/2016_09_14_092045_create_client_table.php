<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     * Generates the clients table,
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->nullable()->unsigned();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
            $table->tinyInteger('deleted')->default(0);
            $table->index(['name', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     * Drops the clients table,
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
