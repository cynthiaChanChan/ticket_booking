@extends('layouts.master')

@section('body')
	<div class="bg-soft">
		<div class="container">
			<h1 class="title bold">{{ $concert->title }}</h1>
			<h2 class="subtitle">{{ $concert->subtitle }}</h2>
			<ul>
				<li>
					<img src='{{ asset("images/calendar.svg") }}' alt="calendar icon">
					<span class="bold">{{ $concert->formatted_date }}</span>
				</li>
				<li>
					<img src='{{ asset("images/time.svg") }}' alt="time icon">
					<span class="bold">{{ $concert->formatted_start_time }}</span>
				</li>
				<li>
					<img src='{{ asset("images/currency-dollar.svg") }}' alt="currency-dollar icon">
					<span class="bold">{{ $concert->ticket_price_in_dollars }}</span>
				</li>
				<li>
					<img src='{{ asset("images/location.svg") }}' alt="location icon">
					<span class="bold">{{ $concert->venue }}</span>
					<p>{{ $concert->venue_address }} {{ $concert->city }}, {{ $concert->state }} {{ $concert->zip }}</p>
				</li>
				<li>
					<img src='{{ asset("images/information-outline.svg") }}' alt="information icon">
					<span class="bold">Additonal Information</span>
					<p>{{ $concert->additional_information }}</p>
				</li>
			</ul>
			<form id="buy_tickets">
				<div class="price">
					<h5>Price</h5>
					<h5 class="num_wrapper">{{ $concert->ticket_price_in_dollars }}</h5>
				</div>
				<div class="num">
					<label for="quantity">Qty</label>
					<input class="num_wrapper" id="quantity" value="1" type="number">
				</div>
				<button type="submit" id="submit_btn" class="bold">Buy Tickets</button>
			</form>
		</div>
	</div>
@endsection

@push('beforeScripts')
<script>
    window.myApp.concert = @json($concert);
</script>
<script src="https://checkout.stripe.com/checkout.js"></script>
@endpush