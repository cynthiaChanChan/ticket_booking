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
                <a href="{{ route('backstage.published-concert-orders.index', $concert) }}" class="btn-inline bold mg-right-sm">Orders</a>
                <a href="{{ route('backstage.concert-messages.new', $concert) }}" class="btn-inline">Message Attendees</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="message-box">
            <div class="message-card">
                <h1 class="list-title text-center">New Message</h1>
                
                @if(session('flash'))
                <div class="alert alert--success">Message sent!</div>
                @endif
                <form class="form block" action="#" method="POST">
                {{ csrf_field() }}
                    <div class="form-group mg-bottom-sm">
                        <label class="form__label">Subject</label>
                        <input type="text" class="form__control" name="subject" required="required">
                    </div>
                    <div class="form-group mg-bottom-sm">
                        <label class="form__label">Message</label>
                        <textarea name="message" rows="10" class="form__control" required="required"></textarea>
                    </div>
                    <div class="text-center">
                        <button class="btn btn--normal" type="submit">Send Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection