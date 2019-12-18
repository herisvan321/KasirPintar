<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('staff')->insert([
        	'name' => 'staff',
        	'email' => 'staff@staff.com',
        	'password' => Hash::make('12345678')
        ]);
        DB::table('owners')->insert([
        	'name' => 'owner',
        	'email' => 'owner@owner.com',
        	'password' => Hash::make('12345678')
        ]);
    }
}
