@extends('layouts.master')
@section('body')
	<div class="container order-box">
	    <div class="order">
	    	<header class="heading-primary order__header">
				<h1 class="heading-primary--main order__summary">Order Summary</h1>
				<span class="heading-primary--sub order__confirmation-num">{{ $order->confirmation_number }}</span>
			</header>
			<div class="order__desc">
				<p class="order__total">Order Total: ${{ number_format($order->amount / 100, 2) }}</p>
				<p class="order__card">Billed to Card #: **** **** **** {{ $order->card_last_four }}</p>
			</div>
		</div>
		<div class="ticket-cards">
			<h4 class="ticket-cards__title">Your tickets</h4>

			@foreach($order->tickets as $ticket)
			<div class="ticket-card">
				<div class="ticket-card__title-box">
					<h4 class="ticket-card__title">
						<span class="ticket-card__title--main">{{ $ticket->concert->title }}</span>
						<span class="ticket-card__title--sub">{{ $ticket->concert->subtitle }}</span>
					</h4>
					<p class="ticket-card__admission">
						<span class="ticket-card__admission--main">General Admission</span>
						<span class="ticket-card__admission--sub">Admit one</span>
					</p>
				</div>
				<div class="ticket-card__detail-box">
					<div class="ticket-card__detail">
						<svg class="ticket-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 3.995C1 2.893 1.893 2 2.995 2h14.01C18.107 2 19 2.893 19 3.995v14.01A1.995 1.995 0 0 1 17.005 20H2.995A1.995 1.995 0 0 1 1 18.005V3.995zM3 6h14v12H3V6zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z" fill-rule="evenodd"/></svg>

						<p class="ticket-time">
							<time datetime="{{ $ticket->concert->date->format('Y-m-d H:i') }}">
								<span class="bold">{{ $ticket->concert->date->format('l, F jS, Y') }}</span>
							</time>
							<br>
							<span>{{ $ticket->concert->date->format('g:ia') }}</span>
						</p>
					</div>
					<div class="ticket-card__detail">
						<svg class="ticket-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20s7-9.134 7-13A7 7 0 0 0 3 7c0 3.866 7 13 7 13zm0-11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill-rule="evenodd"/></svg>

						<p class="ticket-address">
							<span class="bold">{{ $ticket->concert->venue }}</span><br>
							<span>{{ $ticket->concert->venue_address }}</span><br>
							<span>{{ $ticket->concert->city }}, {{ $ticket->concert->state }} {{ $ticket->concert->zip }}</span>
						</p>
					</div>
				</div>
				<div class="ticket-card__note-box">
					<span class="ticket-code">{{ $ticket->code }}</span>
					<span class="ticket-email">{{ $order->email }}</span>
				</div>
			</div>
			@endforeach
		</div>										
	</div>	
@endsection
