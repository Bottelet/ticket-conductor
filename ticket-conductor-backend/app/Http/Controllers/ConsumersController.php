<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consumer;

class ConsumersController extends Controller
{
	public function index()
	{
		return Consumer::all();
	}

	public function consumerEmails()
	{
		return Consumer::pluck('email');
	}

	public function show($id)
	{
		return Consumer::find($id);
	}

	public function tickets($id)
	{
		return Consumer::find($id)->tickets;
	}

	public function update(Request $request, $id)
	{

		Consumer::find($id)->update($request->all());

		return "Consumer updated";
	}
}
