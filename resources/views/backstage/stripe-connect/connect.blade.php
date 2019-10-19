@extends('layouts.master');

@section('body')

    <div class="container">
        <div class="modal">
            <h1 class="heading-primary heading-primary--main mg-bottom-bg">Connect Your Stripe Account</h1>
            <p class="mg-bottom-bg">Good news, Ticketbeast now integrated directly with your Stripe account!</p>
            <p class="mg-bottom-bg">To continue, connect your Stripe account by clicking the button below:</p>
            <a href="{{ route('backstage.stripe-connect.authorize') }}" class="btn btn--normal">Connect with Stripe</a>
        </div>
    </div>

@endsection