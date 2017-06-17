@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            {{-- SideBar --}}
            @include('partials.profileSidebar', ["page" => "beneficiaries"])

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0" style="margin-top: 30px;">

                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-11 px-0">
                        <h2 class="dash-subtitle m-0">@lang('payment.bnfNew')</h2>
                    </div>

                    <div class="col-xs-1 px-0">
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">

                    {{-- Add Beneficiary Form --}}
                    <form action="#" method="get" id="add-bnf-form">
                        {{ csrf_field() }}

                        {{-- Firstname --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-user bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-firstname"
                                   name="firstname" placeholder="@lang('payment.bnfFirstname')" autocomplete="off">
                        </div>

                        {{-- Lastname --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-user bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-lastname"
                                   name="lastname" placeholder="@lang('payment.bnfLastname')" autocomplete="off">
                        </div>

                        {{-- Account Number --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-card bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                   id="bnf-accountnumber"
                                   name="accountnumber" placeholder="@lang('payment.bnfCC')" autocomplete="off">
                        </div>

                        {{-- Address --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-globe bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-address"
                                   name="address" placeholder="@lang('payment.bnfAddr')" autocomplete="off">
                        </div>

                        {{-- Phone Number --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-mobile bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                   id="bnf-phone"
                                   name="phone" placeholder="@lang('payment.bnfPhone')" autocomplete="off">
                        </div>

                        {{-- Fax Number --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-fax bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                   id="bnf-fax"
                                   name="fax" placeholder="@lang('payment.bnfFax')" autocomplete="off">
                        </div>

                        {{-- Bank Name --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-bank bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-bankname"
                                   name="bankname" placeholder="@lang('payment.bnfBank')" autocomplete="off">
                        </div>

                        {{-- Branch Address --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-branch bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-branch"
                                   name="branch" placeholder="@lang('payment.bnfBranch')" autocomplete="off">
                        </div>

                        {{-- Swift Code --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-swift bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                   id="bnf-swift"
                                   name="swift" placeholder="@lang('payment.bnfSwift')" autocomplete="off">
                        </div>

                        {{-- iBan Number --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-code bsIcon"></i>
                            <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                   id="bnf-iban"
                                   name="iban" placeholder="@lang('payment.bnfIban')" autocomplete="off">
                        </div>
                        {{--Form Actions--}}
                        <div class="row p-0 m-0">
                            <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                                <a href="/beneficiaries" class="btn fanexBtnOutlineGrey" id="backBtn"
                                   value="Back">@lang('payment.back')</a>
                            </div>
                            <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                                <input type="submit" class="btn fanexBtnOrange" id="paymentBtn"
                                       value="@lang('profile.bnfSave')"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker();

            $(window).resize(function () {
                if ($(window).width() > 993) {
                    $('#profile-sidebar').stick_in_parent({
                        "offset_top": 95
                    });
                }
                else {
                    $('#profile-sidebar').trigger("sticky_kit:detach");
                }
            });

            if ($(window).width() > 993) {
                $('#profile-sidebar').stick_in_parent({
                    "offset_top": 95
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