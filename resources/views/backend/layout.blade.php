<!DOCTYPE html>
<html lang="ja">
    <head>
        @include('backend.shared.partials.meta')
        @yield('title')
        @include('backend.shared.partials.css')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body @if(Auth::guard()->check()) class="toggled sw-toggled" @endif>
        @if (Auth::guard()->guest())
            @yield('login')
        @else
            @include('backend.shared.partials.header')
            @yield('content')
            @include('backend.shared.components.preloader')
            @include('backend.shared.partials.footer')
        @endif
        @include('backend.shared.partials.js')
        @include('backend.shared.partials.search')
        @yield('unique-js')
    </body>
</html>
