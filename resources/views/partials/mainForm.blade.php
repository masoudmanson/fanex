<div class="mainForm @if($beneficiary) staticMainForm @endif">
    {{-- Form Loading Container --}}
    <div id="mainFormLoader" style="display:none;">
        <div class="errors" style="display: none"></div>
        <div class="spinner2">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    @if($beneficiary)
        <h1 class="pb-5 mt-0 dash-title">@lang('index.formSendTo', ['name'=> '<b>'.$beneficiary->firstname.' '.$beneficiary->lastname.'</b>'])</h1>
    @else
        <h2 class="pb-3 mt-0">@lang('index.formTitle')</h2>
    @endif
    <form @if($beneficiary) action="{{ route('proforma_with_selected_bnf_profile', ['beneficiary' => $beneficiary->id]) }}" method="get" @else action="{{ route('createOrSelect') }}" method="post" @endif>
        {{ csrf_field() }}

        {{-- Destination Country --}}
        <div class="form-group bsWrapper">
            <i class="icon-globe bsIcon"></i>
            <select class="form-control fanexInput selectpicker indexSelectBox fanex-border" data-style="fanexInput" name="country"
                    id="exCountry">
                <option value="" selected="selected" disabled="disabled">@lang('index.formCountry')</option>

                @foreach($country_list as $country)
                    <option value="{{ $country['code'] }}" @if(!$country['enable']) disabled @endif data-currency="{{ json_encode($country['currency']) }}">
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Amount + Currency --}}
        <div class="row">
            {{-- Currency --}}
            <div class="col-md-6 col-sm-12 pr-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-coin bsIcon"></i>
                    <select class="form-control fanexInput selectpicker disabledForm exCurrency" data-style="fanexInput"
                            name="currency"
                            id="exCurrency" disabled="disabled">
                        <option value="" selected="selected" disabled="disabled">@lang('index.formCurrency')</option>
                    </select>
                </div>
            </div>

            {{-- Amount --}}
            <div class="col-md-6 col-sm-12 pl-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-change bsIcon"></i>
                    <input type="text" class="form-control fanexInput disabledForm" id="exAmount"
                           name="amount" placeholder="@lang('index.formAmount')" autocomplete="off">
                </div>
            </div>
        </div>

        {{-- Captcha --}}
        <div class="row">
            {{-- Captcha Image --}}
            <div class="col-sm-6 col-xs-12 pr-md-2">
                <div class="form-group bsWrapper">
                    <a href="javascript: reloadCaptcha();" class="captchaRefresher"><i
                                class="icon-refresh bsIcon"></i></a>
                    <div class="fanexInput fanexCaptcha" style="text-align:center; overflow: hidden;">
                        <img src="{{ captcha_src('flat') }}" alt="captcha" class="captcha-img"
                             data-refresh-config="flat">
                    </div>
                </div>
            </div>
            {{-- Captcha Input --}}
            <div class="col-sm-6 col-xs-12 pl-md-2">
                <div class="form-group bsWrapper">
                    <i class="icon-check bsIcon"></i>
                    <input type="text" class="form-control fanexInput disabledForm" name="captcha" id="captcha"
                           placeholder="@lang('index.formCaptcha')">
                </div>
            </div>
        </div>

        {{-- Temproray Calculated Amount --}}
        <div class="tempAmount" style="display: none;">
            <h2>@lang('index.formCost') <span id="tempAmountCash"></span> @lang('index.formTo') <span
                        id="tempAmountCountry"></span> @lang('index.formIs'):</h2>
            <div class="tempAmountWrapper">
                <span class="calcAmount"></span>
                <span class="tempCurrency">@lang('index.formRials')</span>
            </div>
        </div>

        {{-- Form Submition --}}
        <div class="row">
            {{-- Calculate Amount --}}
            <div class="col-sm-6 col-xs-12 pr-md-2 mb-xs-4">
                <input type="button" class="btn fanexBtnOutlineOrange disabledForm" value=@lang('index.calculate') id="calcBtn"
                       onclick="getAmount()" disabled/>
            </div>

            {{-- Go For Payment --}}
            <div class="col-sm-6 col-xs-12 pl-md-2">
                <input type="hidden" name="product_id" id="product_id" value="">
                <input type="submit" class="btn fanexBtnOutlineGrey disabledForm" id="paymentBtn"
                       value=@lang('index.pay') name="payment" disabled/>
                <input type="text" id="fakeInput" name="fakeInput" style="height:0; width:0; opacity: 0">
            </div>
        </div>

    </form>
</div>
