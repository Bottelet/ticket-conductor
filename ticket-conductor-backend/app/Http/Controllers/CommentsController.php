<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Ticket;

class CommentsController extends Controller
{
    public function create($id, Request $request)
    {
      $comment = new Comment($request->all());
      $ticket = Ticket::find($id);
      $ticket->comments()->save($comment);

      return "Comment saved";
    }
}
