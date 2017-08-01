<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    public function index()
    {
        return Group::all();
    }
    public function users()
    {
    	$groups = Group::with('users')->get();

    	$formatted_groups = [];
    	foreach ($groups as $group) {
    		$formatted_groups[] = ['header' => $group->name];
    		foreach ($group->users as $user) {
    			$formatted_groups[] = ['id' => $user->id, 'name' => $user->first_name . ' ' . $user->last_name, 'group' => $group->name];
    		}
    		
    	}

    	return $formatted_groups;
    }
    public function create(Request $request)
    {
        Group::create($request->all());
    }
}
