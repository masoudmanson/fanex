<nav class="navbar navbar-default @if(!empty($type)) @if($type == "dashboard") navbar-fixed-top dashboard-nav @endif @endif">
    <div class="container-fluid px-sm-0 px-md-4 px-lg-4">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <div class="navbar-header">
            <a class="navbar-brand" href="/">FANEx</a>
        </div>

        {{-- Collect the nav links, forms, and other content for toggling --}}
        {{-- Authentication Links --}}
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">{{ Auth::user()->name }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endif
        </ul>
    </div>
</nav>