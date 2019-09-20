@extends('layouts.master')

@section('body')
<div class="flex-col full-height">
    <header>
        <nav class="navbar">
            <div class="container nav-content">
                <div>
                    <img class="logo" src="{{ url('images/logo.svg') }}" alt="logo">
                </div>
                <div class="logout">
                    <form action="{{ route('auth.logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit">Log out</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    
    @yield('backstageContent')
    
    <footer class="backstage-footer">
        <div class="container">&copy; {{ date('Y') }}</div>
    </footer>
</div>
@endsection