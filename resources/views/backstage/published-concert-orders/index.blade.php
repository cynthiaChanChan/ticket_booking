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
                <a href="#" class="btn-inline bold mg-right-sm">Orders</a>
                <a href="#" class="btn-inline">Message Attendees</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class='list-title'>Overview</h2>
        <div class="progress-card">
            <div class="progress-card__section">
                <p class="mg-bottom-sm">This show is {}% sold out</p>
                <progress class="progress" value="{{ $concert->ticketsSold() }}" max="255">63.11</progress>
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
                    <div class="bold">{{ $concert->ticketsRemaining() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mg-bottom-md">
        <h2 class='list-title'>Recent Orders</h2>
        <div class="orders-list">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Tickets</th>
                        <th>Amount</th>
                        <th>Card</th>
                        <th>Purchased</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->ticketQuantity() }}</td>
                        <td>{{ $order->formatted_amount }}</td>
                        <td>
                            <span>****</span>
                            {{ $order->card_last_four }}
                        </td>
                        <td>{{ $order->formatted_date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection