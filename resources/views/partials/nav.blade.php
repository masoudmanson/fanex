<nav class="navbar navbar-toggleable-md">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#fanexNav" aria-controls="fanexNav" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="/">
        FANEx
    </a>

    <div class="collapse navbar-collapse" id="fanexNav">
        <ul class="navbar-nav mr-auto">

        </ul>

        {{-- Authentication Links --}}
        <ul class="navbar-nav">
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
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();"> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endif
        </ul>
    </div>
</nav>