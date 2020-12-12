<header id="header" class="top-head">
    <!-- Static navbar -->
    <nav class="navbar navbar-default">
       <div class="container-fluid">
          <div class="row">
             <div class="col-md-4 col-sm-12 left-rs">
             </div>
             <div class="col-md-8 col-sm-12">
                <div class="right-nav">
                   <div class="login-sr">
                      <div class="login-signup">
                         <ul>
                            @if(Auth::check())
                            <li><h3>{{ Auth::user()->name }}</h3></li>
                            <li><h2>{{ Auth::user()->user_credit }}</h2></li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a class="custom-b" href="{{ route('register') }}">Sign up</a></li>
                            @endif
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <!--/.container-fluid -->
    </nav>
 </header>
