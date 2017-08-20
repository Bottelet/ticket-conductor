<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function create(Request $request)
    {
      Comment::create($request->all());
    }
}
