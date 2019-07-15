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
						<span class="ticket-title-main">Sing with Me</span>
						<span class="ticket-title-sub">with Jodie Chan</span>
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
							<span class="bold">Sunday, October 16, 2011</span>
							<span>Doors at 9:00PM</span>
						</p>
					</div>
					<div class="ticket-detail-wrapper">
						<img class="ticket-icon" src='{{ asset("images/location_active.svg") }}' alt="map icon">
						<p class="ticket-address">
							<span class="bold">Music Hall of Newyork</span>
							<span>123 Main St.</span>
							<span>Brooklyn, New York 14259</span>
						</p>
					</div>
				</div>
				<div class="ticket-extra-info-box">
					<span class="ticket-code">{{ $ticket->code }}</span>
					<span class="ticket-email">somebody@example.com</span>
				</div>
			</div>
			@endforeach
		</div>								
		</div>		
	</div>	
@endsection
