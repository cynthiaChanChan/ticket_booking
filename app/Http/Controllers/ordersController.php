<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class ordersController extends Controller
{
    public function show($confirmationNumber) 
    {
    	$order = Order::findByConfirmationNumber($confirmationNumber);
    	return view("orders.show", ['order' => $order]);
    }
}
