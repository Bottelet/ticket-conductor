<?php

namespace App\Listeners;

use App\Events\NewCollaborators;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Notifications\CollaboratorsWasUpdated;

class NotifyCollaborators
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewCollaborators  $event
     * @return void
     */
    public function handle(NewCollaborators $event)
    {
        $users = $event->ticket->users;
      
        Collect($users)
        ->each(function ($user) use ($event) {
            $user->notify(new CollaboratorsWasUpdated($event));
        });
    }
}
