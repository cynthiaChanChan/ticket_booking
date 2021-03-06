@extends('layouts.backstage')

@section('backstageContent')
<div class="flex-fit">
    <div class="backstage-bar">
        <div class="container flex-sb-center">
            <h1>Your concerts</h1>
            <a href="{{ route('backstage.concerts.new') }}" class="btn btn--normal">Add Concert</a>
        </div>
    </div>
    <section class="container">
        <h2 class="list-title">Published</h2>
        <div class="your-concerts">
            @foreach ($publishedConcerts as $concert)
            <div class='concert-card mg-bottom-sm'>
                <h3>{{ $concert->title }}</h3>
                <p class="concert-card__subtitle">{{ $concert->subtitle }}</p>
                <div class="mg-bottom-tn concert-card__item">
                    <svg class="concert-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20s7-9.134 7-13A7 7 0 0 0 3 7c0 3.866 7 13 7 13zm0-11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill-rule="evenodd"/></svg>
                    {{ $concert->venue }} &ndash; {{ $concert->city }}, {{ $concert->state }}
                </div>
                <div class="mg-bottom-sm concert-card__item">
                    <svg class="concert-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 3.995C1 2.893 1.893 2 2.995 2h14.01C18.107 2 19 2.893 19 3.995v14.01A1.995 1.995 0 0 1 17.005 20H2.995A1.995 1.995 0 0 1 1 18.005V3.995zM3 6h14v12H3V6zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z" fill-rule="evenodd"/></svg>
                    {{ $concert->formatted_date }} @ {{ $concert->formatted_start_time }}
                </div>
                <div>
                    <a class="btn btn--grey" href="{{ route('backstage.published-concert-orders.index', $concert) }}">Manage</a>
                    <a class="btn-inline" href="{{ route('concerts.show', $concert) }}">Public Link</a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <section class="container">
        <h2 class="list-title">Drafts</h2>
        <div class="your-concerts">
            @foreach ($unpublishedConcerts as $concert)
            <div class='concert-card mg-bottom-sm'>
                <h3>{{ $concert->title }}</h3>
                <p class="concert-card__subtitle">{{ $concert->subtitle }}</p>
                <div class="mg-bottom-tn concert-card__item">
                    <svg class="concert-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 20s7-9.134 7-13A7 7 0 0 0 3 7c0 3.866 7 13 7 13zm0-11a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" fill-rule="evenodd"/></svg>
                    {{ $concert->venue }} &ndash; {{ $concert->city }}, {{ $concert->state }}
                </div>
                <div class="mg-bottom-sm concert-card__item">
                    <svg class="concert-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 3.995C1 2.893 1.893 2 2.995 2h14.01C18.107 2 19 2.893 19 3.995v14.01A1.995 1.995 0 0 1 17.005 20H2.995A1.995 1.995 0 0 1 1 18.005V3.995zM3 6h14v12H3V6zm2-6h2v2H5V0zm8 0h2v2h-2V0zM5 9h2v2H5V9zm0 4h2v2H5v-2zm4-4h2v2H9V9zm0 4h2v2H9v-2zm4-4h2v2h-2V9zm0 4h2v2h-2v-2z" fill-rule="evenodd"/></svg>
                    {{ $concert->formatted_date }} @ {{ $concert->formatted_start_time }}
                </div>
                <div>
                    <a class="btn btn--grey" href="{{ route('backstage.concerts.edit', ['id' => $concert->id]) }}">Edit</a>
                    <form class="inline-block" action="{{ route('backstage.published-concerts.store') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="concert_id" value="{{ $concert->id }}">
                    <button class="btn-inline" type="submit">Publish</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection