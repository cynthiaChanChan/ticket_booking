@extends('layouts.backstage')

@section('backstageContent')
<div class="flex-fit">
    <div class="backstage-bar">
        <div class="container flex-sb-center">
            <h1>
                <strong>{{ $concert->title }}</strong>
                <span class="slash">/</span>
                <span>{{ $concert->formatted_date }}</span>
            </h1>
            <div class="btns">
                <a href="{{ route('backstage.published-concert-orders.index', ['id' => $concert->id]) }}" class="btn-inline bold mg-right-sm">Orders</a>
                <a href="{{ route('backstage.concert-messages.new', ['id' => $concert->id]) }}" class="btn-inline">Message Attendees</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class='list-title'>Overview</h2>
        <div class="progress-card">
            <div class="progress-card__section">
                <p class="mg-bottom-sm">This show is {{ $concert->percentSoldOut() }}% sold out</p>
                <progress class="progress" value="{{ $concert->ticketsSold() }}" max="{{ $concert->totalTickets() }}">63.11</progress>
            </div>
            <div class="progress-card__list">
                <div class="progress-card__item">
                    <h3>Total Tickets Remaining</h3>
                    <div class="bold">{{ $concert->ticketsRemaining() }}</div>
                </div>
                <div class="progress-card__item">
                    <h3>Total Tickets Sold</h3>
                    <div class="bold">{{ $concert->ticketsSold() }}</div>
                </div>
                <div class="progress-card__item">
                    <h3>Total Revenue</h3>
                    <div class="bold">${{ $concert->revenueInDollars() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mg-bottom-md">
        <h2 class='list-title'>Recent Orders</h2>
        <div class="orders-list">
            @if($orders->isEmpty())
            <div class="text-center">
                No orders yet.
            </div>
            @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Tickets</th>
                        <th>Amount</th>
                        <th class="sm-hide">Card</th>
                        <th class="sm-hide">Purchased</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->ticketQuantity() }}</td>
                        <td>{{ number_format($order->amount / 100, 2) }}</td>
                        <td class="sm-hide"> 
                            <span>****</span>
                            {{ $order->card_last_four }}
                        </td>
                        <td class="sm-hide">{{ $order->created_at->format('M j, Y, g:ia') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection