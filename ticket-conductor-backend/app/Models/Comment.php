<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
