<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	App\Models\Group::create([
    		'name' => 'Management',
    		'description' => 'A group for all management'
    		]);
    }
}
