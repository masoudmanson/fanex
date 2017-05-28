<nav class="navbar navbar-fixed-bottom2">
    <div class="container-fluid">
        <div class="fanexFooter">
            {{-- Footer Left List --}}
            <ul class="footerLeft">
                <li>
                    <a href="/terms" class="nav-link">Terms And Conditions</a>
                </li>
                <li>
                    <a href="/about" class="nav-link">About Us</a>
                </li>
                <li>
                    <a href="/contact" class="nav-link">Contact Us</a>
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
                    <a href="#" class="nav-link"><i class="icon-instagram"></i></a>
                </li>
                <li class="copyright">
                    <a href="/" style="font-size: 16px;">FANEx &copy; {{ \Carbon\Carbon::now()->year }}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>