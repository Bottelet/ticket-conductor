<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Ticket;

class CommentsController extends Controller
{
    public function create($ticket_id, Request $request)
    {
      $comment = new Comment(['text' => $request->text, 'user_id' => auth()->user()->id]);
      $ticket = Ticket::find($ticket_id);
      $ticket->comments()->save($comment);

      return "Comment saved";
    }

    public function show($ticket_id)
    {
      return Ticket::find($ticket_id)->comments;
    }
}
