<?php var_dump($order);
die;
?>

@extends('layouts.master')
@section('body')
	<div class="bg-soft">
	    <div class="order-box">
	    	<header class="header order-border-bottom">
				<h1 class="order-summary">Order Summary</h1>
				<span class="comfirmation-num">{{ $order->confirmation_number }}</span>
			</header>
			<div class="order-desc order-border-bottom">
				<h2 class="order-total">Order Total: ${{ number_format($order->amount / 100, 2) }}</h2>
				<h3 class="order-card">Billed to Card #: **** **** **** {{ $order->card_last_four }}</h3>
			</div>
		<div class="tickets-box">
			<h4 class="tickets-title">Your tickets</h4>

			@foreach($order->tickets as $ticket)
			<div class="ticket-box">
				<div class="ticket-title-box">
					<h4 class="ticket-title">
						<span class="ticket-title-main">{{ $ticket->concert->title }}</span>
						<span class="ticket-title-sub">{{ $ticket->concert->subtitle }}</span>
					</h4>
					<p class="admission-box">
						<span class="admission-title">General Admission</span>
						<span class="admission">Admit one</span>
					</p>
				</div>
				<div class="ticket-detail-box order-border-bottom">
					<div class="ticket-detail-wrapper">
						<img class="ticket-icon" src='{{ asset("images/calendar_active.svg") }}' alt="calendar icon">
						<p class="ticket-datetime">
							<time datetime="{{ $ticket->concert->date->format('Y-m-d H:i') }}">
								<span class="bold">{{ $ticket->concert->date->format('l, F jS, Y') }}</span>
							</time>
							<span>{{ $ticket->concert->date->format('g:ia') }}</span>
						</p>
					</div>
					<div class="ticket-detail-wrapper">
						<img class="ticket-icon" src='{{ asset("images/location_active.svg") }}' alt="map icon">
						<p class="ticket-address">
							<span class="bold">{{ $ticket->concert->venue }}</span>
							<span>{{ $ticket->concert->venue_address }}</span>
							<span>{{ $ticket->concert->city }}, {{ $ticket->concert->state }} {{ $ticket->concert->zip }}</span>
						</p>
					</div>
				</div>
				<div class="ticket-extra-info-box">
					<span class="ticket-code">{{ $ticket->code }}</span>
					<span class="ticket-email">{{ $order->email }}</span>
				</div>
			</div>
			@endforeach
		</div>								
		</div>		
	</div>	
@endsection
