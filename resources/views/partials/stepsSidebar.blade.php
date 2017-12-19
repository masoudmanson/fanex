<div class="col-lg-3 col-md-4 col-sm-12 px-0 pl-lg-4 pl-md-0 pl-sm-0 pl-xs-0 bnf-auto-sidebar" style="position:static;"
     id="bnf-sidebar">
    <div class="white-card">
        <p class="hideAfterInvoice">@lang('payment.stepsTitle')</p>
        <h3 id="countdown" class="hideAfterInvoice">9:53</h3>
        <ul class="steps-ul">
            <li class="steps-li done">
                <a href="/">
                    <span class="steps-number">1</span>
                    @lang('payment.steps1')
                </a>
            </li>
            <li class="steps-li done">
                <a href="javascript:;">
                    <span class="steps-number">2</span>
                    @lang('payment.steps2')
                </a>
            </li>
            <li class="steps-li @if(!empty($step))
                    @if($step == 3) active
                    @elseif($step > 3) done
                    @endif
                @endif">
                <span class="steps-number">3</span>
                @lang('payment.steps3')
            </li>
            <li class="steps-li @if(!empty($step))
                @if($step == 4) active
                    @elseif($step > 4) done
                    @endif
                @endif">
                <span class="steps-number">4</span>
                @lang('payment.steps4')
            </li>
            <li class="steps-li @if(!empty($step)) @if($step == 5) active @endif @endif">
                <span class="steps-number">5</span>
                @lang('payment.steps5')
            </li>
        </ul>
    </div>
</div>