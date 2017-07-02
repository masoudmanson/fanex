<nav class="navbar
    @if(!empty($type))
        @if($type == "dashboard") dashboard-footer
        @elseif($type == "dark") dark-footer
        @endif
    @endif">
    <div class="container-fluid px-xs-4 p-sm-0 p-md-0 p-lg-0">
        <div class="fanexFooter">
            {{-- Footer Left List --}}
            <ul class="footerLeft">
                <li>
                    <a href="/terms" class="nav-link">@lang('index.terms')</a>
                </li>
                <li>
                    <a href="/about" class="nav-link">@lang('index.about')</a>
                </li>
                <li>
                    <a href="/contact" class="nav-link">@lang('index.contact')</a>
                </li>
            </ul>
            {{-- Footer Right List --}}
            <ul class="footerRight">
                <li class="hasIcon">
                    <a href="#" class="nav-link"><i class="icon-twitter"></i></a>
                </li>
                <li class="hasIcon">
                    <a href="#" class="nav-link"><i class="icon-linkedin"></i></a>
                </li>
                <li class="hasIcon">
                    <a href="https://www.instagram.com/fanex_fanap/" target="_blank" class="nav-link"><i class="icon-instagram"></i></a>
                </li>
                <li class="copyright">
                    <a href="{{ route('index') }}" style="font-size: 16px;">@lang('index.fanex') &copy; @lang('index.year', ['dateFa' => jdate()->format('%Y'), 'dateEn' => \Carbon\Carbon::now()->year ])</a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
</nav>