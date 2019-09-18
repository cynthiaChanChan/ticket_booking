@extends('layouts.master')

@section('body')
	<div class="container ticket">
		<div class="ticket__container">
			<div class="heading-primary mg-bottom-md">
				<h1 class="heading-primary--main">{{ $concert->title }}</h1>
				<h2 class="heading-primary--sub">{{ $concert->subtitle }}</h2>
			</div>
			<ul class="ticket__info">
				<li class="ticket__info__item">
					<img src='{{ asset("images/calendar.svg") }}' alt="calendar icon">
					<span>{{ $concert->formatted_date }}</span>
				</li>
				<li class="ticket__info__item">
					<img src='{{ asset("images/time.svg") }}' alt="time icon">
					<span>{{ $concert->formatted_start_time }}</span>
				</li>
				<li class="ticket__info__item">
					<img src='{{ asset("images/currency-dollar.svg") }}' alt="currency-dollar icon">
					<span>{{ $concert->ticket_price_in_dollars }}</span>
				</li>
				<li class="ticket__info__item">
					<img src='{{ asset("images/location.svg") }}' alt="location icon">
					<span>{{ $concert->venue }}</span>
					<p>{{ $concert->venue_address }} {{ $concert->city }}, {{ $concert->state }} {{ $concert->zip }}</p>
					
				</li>
				<li class="ticket__info__item">
					<img src='{{ asset("images/information-outline.svg") }}' alt="information icon">
					<span>Additonal Information</span>
					<p>{{ $concert->additional_information }}</p>				
				</li>
			</ul>
		</div>
		<div class="cta">
			<ticket-checkout
				concert-id="{{ $concert->id }}" 
				concert-title="{{ $concert->title }}"
				price="{{ $concert->ticket_price }}"
			></ticket-checkout>
		</div>
	</div>
@endsection

@push('beforeScripts')

<script src="https://checkout.stripe.com/checkout.js"></script>
@endpush