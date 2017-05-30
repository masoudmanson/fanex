@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>Beneficiary Information</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-md-6 col-sm-12 p-0 pr-lg-3 pb-md-3">
                        <h2 class="dash-subtitle">Add a New Beneficiary</h2>

                        {{-- Add Beneficiary Form --}}
                        <form action="#" method="get" id="add-bnf-form">
                            {{ csrf_field() }}

                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-firstname"
                                       name="firstname" placeholder="Firstname" autocomplete="off">
                            </div>

                            {{-- Lastname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-lastname"
                                       name="lastname" placeholder="Lastname" autocomplete="off">
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-card bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                       id="bnf-accountnumber"
                                       name="accountnumber" placeholder="Account Number" autocomplete="off">
                            </div>

                            {{-- Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-globe bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-address"
                                       name="address" placeholder="Address" autocomplete="off">
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-mobile bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                       id="bnf-phone"
                                       name="phone" placeholder="Phone Number" autocomplete="off">
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-fax bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                       id="bnf-fax"
                                       name="fax" placeholder="Fax Number" autocomplete="off">
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-bank bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-bankname"
                                       name="bankname" placeholder="Bank Name" autocomplete="off">
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-branch bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-branch"
                                       name="branch" placeholder="Branch Address" autocomplete="off">
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-swift bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                       id="bnf-swift"
                                       name="swift" placeholder="Swift Code" autocomplete="off">
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-code bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                       id="bnf-iban"
                                       name="iban" placeholder="iBan Number" autocomplete="off">
                            </div>

                            {{-- Form Submition --}}
                            {{--<input type="button" class="btn fanexBtnOutlineGrey" id="backBtn" value="Back" name="save"/>--}}
                        </form>

                    </div>

                    {{-- Select From Existing Beneficiaries --}}
                    <div class="col-md-6 col-sm-12 p-0 pl-lg-3">
                        <h2 class="dash-subtitle">or Select From Existings</h2>

                        {{-- Select Beneficiary Box --}}
                        <form action="#" method="get" id="select-bnf-form">
                            {{ csrf_field() }}

                            {{-- Existing Beneficiaries --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="bnf"
                                        id="bnfSelect">
                                    <option value="1">Hamidreza Amouzegar</option>
                                    <option value="2">Mohammad Parham</option>
                                    <option value="3">Pooria Pahlevani</option>
                                    <option value="4">Emad Ghorbani Nia</option>
                                    <option value="5">Masoud Amjadi</option>
                                    <option value="6">Jeffery Way</option>
                                    <option value="7">John Doe</option>
                                    <option value="8">Hillary Duff</option>
                                    <option value="3">Pooria Pahlevani</option>
                                    <option value="4">Emad Ghorbani Nia</option>
                                    <option value="5">Masoud Amjadi</option>
                                    <option value="6">Jeffery Way</option>
                                    <option value="7">John Doe</option>
                                    <option value="8">Hillary Duff</option>
                                </select>
                            </div>

                            {{-- Form Submition --}}
                            {{--<input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn"--}}
                            {{--value=@lang('index.pay') name="payment" disabled/>--}}

                        </form>

                        <div id="bnf-ajax-div" style="display: none;">
                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-firstname">Masoud
                                    Amjadi
                                </div>
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-card bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-accountnumber">
                                    6104337912543665
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-globe bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-address">#123, Noavari
                                    12, Pardis Tech PArk, Tehran, Iran
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-mobile bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-phone">09148401824
                                </div>
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-fax bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-fax">02171951111</div>
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-bank bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-bankname">Pasargad
                                </div>
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-branch bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-branch">#12, Pasargad
                                    13, Africa Blv, Tehran, Iran
                                </div>
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-swift bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-swift">
                                    54584534468431346463131
                                </div>
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-code bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-iban">
                                    4646464000011054048880
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <input type="button" class="btn fanexBtnOutlineGrey" id="backBtn" value="Back"/>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        <input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn"
                               value="Show Proforma"/>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            <div class="col-lg-3 col-md-4 col-sm-12 pr-0 pl-lg-4 pl-md-0 pl-sm-0 pl-xs-0" style="position:static;" id="bnf-sidebar">
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
                        <li class="steps-li active">
                            <span class="steps-number">3</span>
                            Beneficiary Info
                        </li>
                        <li class="steps-li">
                            <span class="steps-number">4</span>
                            Checkout
                        </li>
                        <li class="steps-li">
                            <span class="steps-number">5</span>
                            Finish
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/index.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker();

            $(window).resize(function () {
                if ($(window).width() > 993) {
                    $('#bnf-sidebar').stick_in_parent({
                        "offset_top": 25
                    });
                }
            });

            if ($(window).width() > 993) {
                $('#bnf-sidebar').stick_in_parent({
                    "offset_top": 25
                });
            }

            $('html, body, .dropdown-menu .inner').niceScroll({
                cursorcolor: "#000",
                cursoropacitymin: 0.1,
                cursoropacitymax: 0.3,
                cursorwidth: "5px",
                cursorborder: "none",
                cursorborderradius: "5px"
            });

            $(".numberTextField").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl/cmd+A
                    (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+C
                    (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+X
                    (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

            var tenMins = new Date().getTime() + (1 * 60 * 1000);
            $('#countdown').countdown(tenMins, function (event) {
                $(this).html(event.strftime('%M:%S'));
            }).on('finish.countdown', function () {
                $('#countdown').html('Time Out!').addClass('alert shake animated');
            });

            $('#bnfSelect').on('change', function () {
                $('#add-bnf-form').css({"opacity": 0.5});
                $('#bnf-ajax-div').slideDown(300);
            });

            $('#add-bnf-form input').on('focus', function () {
                $('#add-bnf-form').css({"opacity": 1});
                $('#bnf-ajax-div').slideUp(300);
            });

        });
    </script>
@endsection