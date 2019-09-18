@extends('layouts.backstage')

@section('backstageContent')
<div class="add-concert">
    <div class="container">
        <h1>Add a concert</h1>
    </div>
</div>

<form action="{{ url('backstage/concerts') }}" method="POST" class="form create-form" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    @if ($errors->any())
    <div class="container mg-bottom-sm">
        <div class="alert alert--danger">
            <h2 class="alert__title">
                There {{ $errors->count() == 1 ? 'is' : 'are'}} {{ $errors->count() }} {{ str_plural('error', $errors->count()) }} with this concert:
            </h2>
            <ul class="alert__list">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="form-part">
        <div class="container form-part__container">
            <div class="form-info">
                <h2 class="mg-bottom-sm">Concert Details</h2>
                <p class="mg-bottom-sm">Tell us who's playing! <em>(Please be Slayer!)</em></p>
                <p class="mg-bottom-sm">Include the headliner in the concert name, use the subtitle section to list any opening bands, and add any important information to the description.</p>
            </div>
            <div class="form-card">
                <div class="form__group mg-bottom-sm {{ $errors->first('title', 'has-error') }}">
                    <label for="" class="form__label">Title</label>
                    <input class="form__control" type="text" name="title" value="{{ old('title') }}" placeholder="The Headliners">
                </div>
                <div class="form__group mg-bottom-sm {{ $errors->first('subtitle', 'has-error') }}">
                    <label for="" class="form__label">Subtitle</label>
                    <input class="form__control" type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="with The Openers (optional)">
                </div>
                <div class="form__group mg-bottom-sm {{ $errors->first('additional_information', 'has-error') }}">
                    <label for="" class="form__label">Additional Information</label>
                    <textarea  class="form__control" rows="4" name="additional_information" value="{{ old('additional_information') }}" placeholder="This concert is 19+ (optional)">
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="form-part">
        <div class="container form-part__container">
            <div class="form-info">
                <h2 class="mg-bottom-sm">Date &amp; Time</h2>
                <p class="mg-bottom-sm">True metalheads really only care about the obscure openers, so make sure they don't get there late!</p>
            </div>
            <div class="form-card flex-list">
                <div class="form__group mg-bottom-sm {{ $errors->first('title', 'has-error') }}">
                    <label for="" class="form__label">Date</label>
                    <input class="form__control" type="date" name="date" value="{{ old('date') }}" placeholder="yyyy-mm-dd">
                </div>
                <div class="form__group mg-bottom-sm {{ $errors->first('subtitle', 'has-error') }}">
                    <label for="" class="form__label">Start Time</label>
                    <input class="form__control" type="text" name="time" value="{{ old('item') }}" placeholder="7:00pm">
                </div>
            </div>
        </div>
    </div>

    <div class="form-part">
        <div class="container form-part__container">
            <div class="form-info">
                <h2 class="mg-bottom-sm">Venue Information</h2>
                <p class="mg-bottom-sm">
                Where's the show? Let attendees know the venue name and address so they can bring the mosh.
                </p>
            </div>
            <div class="form-card">
                <div class="form__group mg-bottom-sm {{ $errors->first('venue', 'has-error') }}">
                    <label for="" class="form__label">Venue Name</label>
                    <input class="form__control" type="text" name="venue" value="{{ old('venue') }}" placeholder="The Mosh Pit">
                </div>
                <div class="form__group mg-bottom-sm {{ $errors->first('subtitle', 'has-error') }}">
                    <label for="" class="form__label">Street Address</label>
                    <input class="form__control" type="text" name="venue_address" value="{{ old('venue_address') }}" placeholder="500 Example Ave.">
                </div>
                <div class="flex-list">
                    <div class="form__group item--4 mg-bottom-sm {{ $errors->first('city', 'has-error') }}">
                        <label for="" class="form__label">City</label>
                        <input class="form__control" type="text" name="city" value="{{ old('city') }}" placeholder="Laraville">
                    </div>
                    <div class="form__group item--4 mg-bottom-sm {{ $errors->first('state', 'has-error') }}">
                        <label for="" class="form__label">State/Province</label>
                        <input class="form__control" type="text" name="state" value="{{ old('state') }}" placeholder="ON">
                    </div>
                    <div class="form__group item--4 mg-bottom-sm {{ $errors->first('zip', 'has-error') }}">
                        <label for="" class="form__label">ZIP</label>
                        <input class="form__control" type="text" name="zip" value="{{ old('zip') }}" placeholder="90210">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-part">
        <div class="container form-part__container">
            <div class="form-info">
                <h2 class="mg-bottom-sm">Tickets &amp; Pricing</h2>
                <p class="mg-bottom-sm">
                Set your ticket price and availability, but don't forget, metalheads are cheap so keep it reasonable.
                </p>
            </div>
            <div class="form-card">
                <div class="flex-list">
                    <div class="form__group mg-bottom-sm {{ $errors->first('ticket_price', 'has-error') }}">
                        <label for="" class="form__label">Price</label>
                        <div class="input-group">
                            <span class="input-group__addon">$</span>
                            <input class="form__control" type="text" name="ticket_price" value="{{ old('ticket_price') }}" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form__group mg-bottom-sm {{ $errors->first('ticket_quantity', 'has-error') }}">
                        <label for="" class="form__label">Ticket Quantity</label>
                        <input class="form__control" type="text" name="ticket_quantity" value="{{ old('ticket_quantity') }}" placeholder="250">
                    </div>
                </div>
                <div class="form__group mg-bottom-sm {{ $errors->first('poster_image', 'has-error') }}">
                    <label for="" class="form__label">Concert Poster</label>
                    <input class="form__control" type="file" name="poster_image" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="container clearfix">
        <button type="submit" class="btn btn--right btn--normal">Add Concert</button>
    </div>
</form>
@endsection