<div class="mainForm">
    {{-- Form Loading Container --}}
    <div id="mainFormLoader" style="display:none;">
        <div class="errors" style="display: none"></div>
        <div class="spinner2">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    {{--{{ dd($country_list) }}--}}
{{--    {{ dd(Countries::keyValue(session('applocale'), 'code', 'name')) }}--}}
{{--    {{ dd(session('applocale')) }}--}}
    <h1 class="pb-3 mt-0">@lang('index.formTitle')</h1>

    <form action="/payment" method="get">
        {{ csrf_field() }}

        {{-- Destination Country --}}
        <div class="form-group bsWrapper">
            <i class="icon-globe bsIcon"></i>
            <select class="form-control fanexInput selectpicker indexSelectBox" data-style="fanexInput" name="country"
                    id="exCountry">
                <option value=""  selected="selected" disabled="disabled">@lang('index.formCountry')</option>
                <optgroup label="@lang('index.formActive')">
                    <option value="Turkey">Turkey</option>
                    <option value="Canada">Canada</option>
                </optgroup>
                <optgroup label="@lang('index.formInactive')">
                    <option value="France" disabled>France</option>
                    <option value="Italy" disabled>Italy</option>
                    <option value="Germany" disabled>Germany</option>
                    <option value="Switzerland" disabled>Switzerland</option>
                    <option value="Sweden" disabled>Sweden</option>
                    <option value="Norway" disabled>Norway</option>
                    <option value="Belgium" disabled>Belgium</option>
                    <option value="Austria" disabled>Austria</option>
                    <option value="Finland" disabled>Finland</option>
                    <option value="Greece" disabled>Greece</option>
                    <option value="Denmark" disabled>Denmark</option>
                    <option value="Netherlands" disabled>Netherlands</option>
                    <option value="Portugal" disabled>Portugal</option>
                    <option value="Spain" disabled>Spain</option>
                    <option value="England" disabled>England</option>
                    <option value="Iraq" disabled>Iraq</option>
                    <option value="Russia" disabled>Russia</option>
                    <option value="China" disabled>China</option>
                    <option value="USA" disabled>USA</option>
                </optgroup>
            </select>
        </div>

        {{-- Amount + Currency --}}
        <div class="row">
            {{-- Amount --}}
            <div class="col-md-6 col-sm-12 pr-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-change bsIcon"></i>
                    <input type="text" class="form-control fanexInput numberTextField" id="exAmount"
                           name="amount" placeholder="@lang('index.formAmount')" autocomplete="off">
                </div>
            </div>
            {{-- Currency --}}
            <div class="col-md-6 col-sm-12 pl-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-coin bsIcon"></i>
                    <select class="form-control fanexInput selectpicker" data-style="fanexInput"
                            name="currency"
                            id="exCurrency">
                        <option value=""  selected="selected" disabled="disabled">@lang('index.formCurrency')</option>
                        <option value="lira">₺ Turkish Lira</option>
                        <option value="euro">€ Euro</option>
                    </select>
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
                    <input type="text" class="form-control fanexInput" name="captcha" id="captcha"
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
                <input type="button" class="btn fanexBtnOutlineOrange" value=@lang('index.calculate') id="calcBtn"
                       onclick="getAmount()" disabled/>
            </div>
            {{-- Go For Payment --}}
            <div class="col-sm-6 col-xs-12 pl-md-2">
                <input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn" value=@lang('index.pay') name="payment" disabled/>
            </div>
        </div>

    </form>
</div>
