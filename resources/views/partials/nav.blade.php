<nav class="navbar navbar-default
    @if(!empty($type))
@if($type == "dashboard") navbar-fixed-top dashboard-nav
        @elseif($type == "dark") dark-header
        @endif
@endif">
    <div class="container-fluid px-xs-4 px-sm-0 px-md-4 px-lg-4">
        {{-- Brand and toggle get grouped for better mobile display --}}
        <div class="navbar-header">
            <a class="navbar-brand" href="/">@lang('index.fanex')</a>
        </div>

        {{-- Authentication Links --}}
        <ul class="nav navbar-nav navbar-right">
            @if (Auth::guest())
                {{-- Change Language Dropdown --}}
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link md-trigger" data-modal="modal-9"> {{-- data-toggle="modal" data-target=".language-modal"> --}}
                        @lang('index.language')
                    </a>
                </li>
                {{--<li class="dropdown nav-item">--}}
                {{--<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">--}}
                {{--@lang('index.language') <span class="caret"></span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu">--}}
                {{--@foreach (Config::get('app.locales') as $lang => $language)--}}
                {{--@if ($lang != App::getLocale())--}}
                {{--<li>--}}
                {{--<a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>--}}
                {{--</li>--}}
                {{--@endif--}}
                {{--@endforeach--}}
                {{--</ul>--}}
                {{--</li>--}}

                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">@lang('index.login')</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">@lang('index.register')</a>
                </li>
            @else
                {{-- Change Language Dropdown --}}
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        @lang('index.language') <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (Config::get('app.locales') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <li>
                                    <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/profile" class="nav-link">{{ Auth::user()->firstname }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> @lang('index.logout')
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endif
        </ul>
    </div>
</nav>

<div class="modal fade language-modal" tabindex="-1" role="dialog" aria-labelledby="Language Modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">@lang('index.langSelect')</h4>
            </div>
            <div class="modal-body">
                <ul class="lang-ul">
                    @foreach (Config::get('app.locales') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <li>
                                <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="md-modal md-effect-9" id="modal-9">
    <div class="md-content">
        <h3>@lang('index.langSelect')</h3>
        <div class="md-body">
            <ul class="lang-ul">
                @foreach (Config::get('app.locales') as $lang => $language)
                    @if ($lang != App::getLocale())
                        <li>
                            <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <button class="md-close md-button">@lang('index.close')</button>
        </div>
    </div>
</div>

<div class="md-overlay"></div>