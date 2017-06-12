<div class="col-lg-3 col-md-4 col-sm-12 pr-0 pl-lg-4 pl-md-0 pl-sm-0 pl-xs-0 bnf-auto-sidebar" style="position:static;"
     id="bnf-sidebar">
    <div class="white-card">
        <p>Rates expire in:</p>
        <h3 id="countdown">9:53</h3>
        <ul class="steps-ul">
            <li class="steps-li done">
                <a href="/">
                    <span class="steps-number">1</span>
                    Price Check
                </a>
            </li>
            <li class="steps-li done">
                <a href="javascript:;">
                    <span class="steps-number">2</span>
                    Login
                </a>
            </li>
            <li class="steps-li @if(!empty($step))
                    @if($step == 3) active
                    @elseif($step > 3) done
                    @endif
                @endif">
                <span class="steps-number">3</span>
                Beneficiary Info
            </li>
            <li class="steps-li @if(!empty($step))
                @if($step == 4) active
                    @elseif($step > 4) done
                    @endif
                @endif">
                <span class="steps-number">4</span>
                Checkout
            </li>
            <li class="steps-li @if(!empty($step)) @if($step == 5) active @endif @endif">
                <span class="steps-number">5</span>
                Finish
            </li>
        </ul>
    </div>
</div>