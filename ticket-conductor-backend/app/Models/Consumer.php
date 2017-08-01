<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'address', 'zipcode', 'city', 'phone', 'country', 'vat', 'company_name'
    ];


    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
