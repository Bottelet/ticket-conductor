<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Consumer;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ticket::all();
    }

    public function collaborators($id)
    {
        $users = Ticket::find($id)->users()->select('id');
        $collaborators = collect();
        foreach ($users->get() as $user) {
         $collaborators->push($user->id);
     }

     return $collaborators;
 }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'type' => 'required',
            'priority' => 'required'
            ]);

        $consumer = Consumer::firstOrCreate(['email' => $request->consumer]);
        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'type' => $request->type,
            'priority' => $request->priority,
            'consumer_id' => $consumer->id
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ticket::find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->update($request->all());
        if ($request->collaborators) {
            $ticket->users()->sync($request->collaborators);
            $ticket->fresh();
            if (config('mail.usemails')) {
                event(new \App\Events\NewCollaborators($ticket));
            }
        }

        return response("Ticket updated");
    }

    public function consumer($id)
    {
        return Ticket::find($id)->consumer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
