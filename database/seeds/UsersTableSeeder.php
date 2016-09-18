<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoiceLineItems = [
            "name" => "{YOUR NAME}",
            "password" => bcrypt("{YOUR PASSWORD}"),
            "email" => "{YOUR EMAIL ADDRESS}",
        ];
        DB::table('users')->insert($invoiceLineItems);
    }
}
