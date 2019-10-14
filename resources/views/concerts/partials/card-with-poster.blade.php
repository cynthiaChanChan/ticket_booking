<div class="concert-box">
    <div class="poster">
        <img src="{{ asset($concert->posterUrl()) }}" alt="">
    </div>
    <div class="concert">
        <div class="concert__container">
            <div class="heading-primary mg-bottom-md">
                <h1 class="heading-primary--main">{{ $concert->title }}</h1>
                <h2 class="heading-primary--sub">{{ $concert->subtitle }}</h2>
            </div>
            <ul class="concert__info">
                <li class="concert__info__item">
                    <img src='{{ asset("images/calendar.svg") }}' alt="calendar icon">
                    <span>{{ $concert->formatted_date }}</span>
                </li>
                <li class="concert__info__item">
                    <img src='{{ asset("images/time.svg") }}' alt="time icon">
                    <span>{{ $concert->formatted_start_time }}</span>
                </li>
                <li class="concert__info__item">
                    <img src='{{ asset("images/currency-dollar.svg") }}' alt="currency-dollar icon">
                    <span>{{ $concert->ticket_price_in_dollars }}</span>
                </li>
                <li class="concert__info__item">
                    <img src='{{ asset("images/location.svg") }}' alt="location icon">
                    <span>{{ $concert->venue }}</span>
                    <p>{{ $concert->venue_address }} {{ $concert->city }}, {{ $concert->state }} {{ $concert->zip }}</p>
                    
                </li>
                <li class="concert__info__item">
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
</div>