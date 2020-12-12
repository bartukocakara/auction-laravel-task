@section('header')
    @include('front-layouts._header')
@show

@section('navbar')
    @include('front-layouts._navbar')
@show

    @yield('content')

@section('footer')
    @include('front-layouts._footer')
@show
