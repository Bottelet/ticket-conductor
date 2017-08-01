<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'type', 'priority', 'consumer_id'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }
}
