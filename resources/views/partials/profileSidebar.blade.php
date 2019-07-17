<h1 class="dash-title">@lang('profile.welcome') <b>{{ Auth::user()->firstname }}</b></h1>

<div class="col-lg-3 col-md-4 col-sm-12 px-0 pr-lg-4 pr-md-0 pr-sm-0 pr-xs-0" style="position:static" id="profile-sidebar">
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
            {{--<li class="profile-li @if($page == "notifications") active @endif">--}}
                {{--<a href="/notifications">--}}
                    {{--<i class="icon-chat"></i> @lang('profile.menuNotify')--}}
                {{--</a>--}}
            {{--</li>--}}
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

    {{--<div class="white-card mt-4 pt-5 pb-3">--}}
        {{--<ul class="profile-ul mb-0">--}}
            {{--<li class="profile-li mb-4">--}}
                {{--<a class="text-small">--}}
                    {{--<i class="icon-card"></i>--}}
                    {{--@lang('profile.menuBalance')--}}
                {{--</a>--}}
                {{--<iframe src="https://gw.fanapium.com/v1/pbc/getcredit" id="myIframe" frameborder="0" style="width: 100%; max-height: 45px; margin-top:6px;"></iframe>--}}
                {{--<a href="https://gw.fanapium.com/v1/pbc/BuyCredit/?redirectUri=http://85.133.159.140:12801/profile&callUri=http://85.133.159.140:12801"--}}
                   {{--class="btn btnMini btnRound fanexBtnMiniOutlineGrey">@lang('profile.menuBalanceAdd')</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</div>--}}
</div>