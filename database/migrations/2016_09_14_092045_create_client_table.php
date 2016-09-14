<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

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
            $table->increments('id')->unsigned();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->uuid('apiKey');
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at')->default(date('Y-m-d H:i:s'));
            $table->tinyInteger('deleted')->default(0);
            $table->index(['name', 'email']);
        });

        DB::getPdo()->exec('
            CREATE TRIGGER clients_on_update BEFORE UPDATE ON clients FOR EACH ROW
            BEGIN
            	SET new.updated_at := now();
            END;
        ');
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
