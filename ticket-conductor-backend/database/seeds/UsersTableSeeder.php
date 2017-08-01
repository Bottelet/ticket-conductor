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
    	App\Models\User::create([
    		'first_name' => 'Casper',
    		'last_name' => 'Bottelet',
    		'email' => 'admin@admin.com',
    		'password' => bcrypt('admin'),
    		'group_id' => 1
    		]);
    }
}
