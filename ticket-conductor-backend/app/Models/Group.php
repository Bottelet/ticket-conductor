<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];
    
    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
