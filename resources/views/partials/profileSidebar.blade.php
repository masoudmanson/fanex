<h1 class="dash-title">Welcome <b>{{ Auth::user()->firstname }}</b></h1>

<div class="col-lg-3 col-md-4 col-sm-12 pl-0 pr-lg-4 pr-md-0 pr-sm-0 pr-xs-0" style="position:static;"
     id="profile-sidebar">
    <div class="white-card">
        <ul class="profile-ul">
            <li class="profile-li @if($page == "transactions") active @endif">
                <a href="/profile">
                    <i class="icon-trans"></i> @lang('profile.menuTrans')
                </a>
            </li>
            <li class="profile-li @if($page == "beneficiaries") active @endif">
                <a href="/beneficiaries">
                    <i class="icon-user"></i> @lang('profile.menuBnf')
                </a>
            </li>
            <li class="profile-li @if($page == "notifications") active @endif">
                <a href="/notifications">
                    <i class="icon-chat"></i> @lang('profile.menuNotify')
                </a>
            </li>
            {{--<li class="profile-li @if($page == "settings") active @endif">--}}
                {{--<a href="/settings">--}}
                    {{--<i class="icon-settings"></i> Settings--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="profile-li">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="icon-exit"></i> @lang('index.logout')
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>