<?php

namespace App;

use App\Concert;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	protected $guarded = [];

    public function concert() 
    {
        return $this->belongsTo(Concert::class);
    }
	
    public function scopeAvailable($query) 
    {
    	return $query->WhereNull('order_id');
    }

    public function release()
    {
    	$this->update(['order_id' => null]);
    }

    public function getPriceAttribute()
    {
        return $this->concert->ticket_price; 
    }
}
