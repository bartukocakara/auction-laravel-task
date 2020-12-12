@section('header')
    @include('layouts._header')
@show
<body class="sidebar-mini layout-fixed sidebar-closed sidebar-collapse" style="height: auto;">
    <div class="wrapper">

    @section('navbar')
        @include('layouts._navbar')
    @show

    @section('sidebar')
        @include('layouts._sidebar')
    @show

    @yield('content')


  <div id="sidebar-overlay"></div></div>
  <!-- ./wrapper -->

@section('footer')
    @include('layouts._footer')
@show
