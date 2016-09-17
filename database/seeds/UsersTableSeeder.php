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
            "name" => "Rhino Africa",
            "password" => bcrypt("blue3232"),
            "email" => "admin@rhinoafrica.com",
        ];
        DB::table('users')->insert($invoiceLineItems);
    }
}
