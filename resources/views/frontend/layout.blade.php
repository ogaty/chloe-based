<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8">
    @include('frontend.shared.meta')
    @include('frontend.shared.css')
    @include('frontend.shared.js')
</head>
<body>
    @include('frontend.shared.header')
    @yield('content')
    @include('frontend.shared.footer')
</body>
</html>
