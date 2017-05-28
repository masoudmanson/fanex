<div class="mainForm">
    {{-- Form Loading Container --}}
    <div id="mainFormLoader" style="display:none;">
        {{--<div class="spinner">--}}
        {{--<div class="double-bounce1"></div>--}}
        {{--<div class="double-bounce2"></div>--}}
        {{--</div>--}}
        <div class="spinner2">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <h1 class="pb-3 mt-0">International Money E-Transfer</h1>

    <form action="/calculate" method="post">
        {{ csrf_field() }}

        {{-- Destination Country --}}
        <div class="form-group bsWrapper">
            <i class="icon-globe bsIcon"></i>
            <select class="form-control fanexInput selectpicker" data-style="fanexInput" name="country"
                    id="exCountry">
                <optgroup label="Active">
                    <option value="Turkey">Turkey</option>
                    <option value="Canada">Canada</option>
                </optgroup>
                <optgroup label="Inactive">
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
                           name="amount" placeholder="Amount" autocomplete="off">
                </div>
            </div>
            {{-- Currency --}}
            <div class="col-md-6 col-sm-12 pl-lg-2">
                <div class="form-group bsWrapper">
                    <i class="icon-coin bsIcon"></i>
                    <select class="form-control fanexInput selectpicker" data-style="fanexInput"
                            name="currency"
                            id="exCurrency">
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
                    <div class="fanexInput" style="text-align:center; overflow: hidden;">
                        <img src="{{ captcha_src('flat') }}" alt="captcha" class="captcha-img"
                             data-refresh-config="flat">
                    </div>
                </div>
            </div>
            {{-- Captcha Input --}}
            <div class="col-sm-6 col-xs-12 pl-md-2">
                <div class="form-group bsWrapper">
                    <i class="icon-check bsIcon"></i>
                    <input type="text" class="form-control fanexInput" name="captcha"
                           placeholder="Enter Captcha Here">
                </div>
            </div>
        </div>

        {{-- Temproray Calculated Amount --}}
        <div class="tempAmount" style="display: none;">
            <h2>Cost of Transferring <span id="tempAmountCash"></span> to <span
                        id="tempAmountCountry"></span> is:</h2>
            <div class="tempAmountWrapper">
                <span class="calcAmount">Country</span>
                <span class="tempCurrency">Rials</span>
            </div>
        </div>

        {{-- Form Submition --}}
        <div class="row">
            {{-- Calculate Amount --}}
            <div class="col-sm-6 col-xs-12 pr-md-2 mb-xs-4">
                <input type="button" class="btn fanexBtnOutlineOrange" value="Calculate"
                       onclick="getAmount()"/>
            </div>
            {{-- Go For Payment --}}
            <div class="col-sm-6 col-xs-12 pl-md-2">
                <input type="submit" class="btn fanexBtnOutlineGrey" value="Pay" name="payment"/>
            </div>
        </div>

    </form>
</div>
