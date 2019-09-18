<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Ticket_booking')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.ico') }}">
        @include('scripts.app')
    </head>
    <body>
        <div id="app">
            @yield('body')
        </div>

        @stack('beforeScripts')
        <script src="{{ asset('js/app.js') }}"></script>        
        @stack('afterScripts')
    </body>
</html>