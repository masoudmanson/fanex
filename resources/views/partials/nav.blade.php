<nav class="navbar navbar-default navbar-fixed-top2">
    <div class="container-fluid">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <div class="navbar-header">
            {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#fanexNav" aria-expanded="false">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}
            <a class="navbar-brand" href="/">FANEx</a>
        </div>

        {{-- Collect the nav links, forms, and other content for toggling --}}
        {{--<div class="collapse navbar-collapse" id="fanexNav">--}}
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
                        <a href="{{ route('logout') }}"  class="nav-link"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>

        {{--</div>--}}
    </div>
</nav>