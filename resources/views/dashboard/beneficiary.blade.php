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
                        <form action="/proforma" method="get" id="select-bnf-form">
                            {{ csrf_field() }}

                            {{-- Existing Beneficiaries --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="bnf"
                                        id="bnfSelect">
                                    <option selected disabled>Select Beneficiary</option>
                                    @foreach($beneficiaries as $bnf)
                                        <option value="{{ $bnf['id'] }}">{{ $bnf['firstname']. ' ' .$bnf['lastname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <div id="bnf-ajax-div" style="display: none;">
                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-name">
                                    Beneficiary Name
                                </div>
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-card bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-accountnumber">
                                    Account Number
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-globe bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-address">
                                    Beneficiary Address
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-mobile bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-phone">
                                    Mobile
                                </div>
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-fax bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-fax">
                                    Fax Number
                                </div>
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-bank bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-bankname">
                                    Bank Name
                                </div>
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-branch bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-branch">
                                    Branch Address
                                </div>
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-swift bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-swift">
                                    Swift Code
                                </div>
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-code bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-iban">
                                    iBan Number
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <a href="/" class="btn fanexBtnNoline">Back Home</a>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        {{--<input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn"--}}
                               {{--value="Show Proforma"/>--}}
                        <a href="/proforma" class="btn fanexBtnOutlineGrey">Show Proforma</a>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 3])
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/index.js') }}"></script>--}}
    <script>
        var beneficiaries = {!! $beneficiaries !!};
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

            $('#bnfSelect').on('change blur', function () {
                $('#add-bnf-form').css({"opacity": 0.5});

                var bnf_id = $(this).val();
                var bnf = beneficiaries[bnf_id-1];
                $('#bnf-ajax-name').text(bnf.firstname+' '+bnf.lastname);
                $('#bnf-ajax-accountnumber').text(bnf.account_number);
                $('#bnf-ajax-address').text(bnf.address);
                $('#bnf-ajax-phone').text(bnf.tel);
                $('#bnf-ajax-fax').text(bnf.fax);
                $('#bnf-ajax-bankname').text(bnf.bank_name);
                $('#bnf-ajax-branch').text(bnf.branch_address);
                $('#bnf-ajax-swift').text(bnf.swift_code);
                $('#bnf-ajax-iban').text(bnf.iban_code);

                $('#bnf-ajax-div').slideDown(300);
            });

            $('#add-bnf-form input').on('focus', function () {
                $('#add-bnf-form').css({"opacity": 1});
                $('#bnf-ajax-div').slideUp(300);
            });

        });
    </script>
@endsection