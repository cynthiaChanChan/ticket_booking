<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $guarded = [];
	
    public function scopeAvailable($query) 
    {
    	return $query->WhereNull('order_id');
    }

    public function release()
    {
    	$this->update(['order_id' => null]);
    }
}
