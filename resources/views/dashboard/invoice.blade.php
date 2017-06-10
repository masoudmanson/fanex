@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>Receipt</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-xs-12 p-0">
                        <h2 class="dash-subtitle">Your Payment Transaction has Ended</h2>
                        <div class="invoice-wrapper mb-4">
                            <h3 class="invoice-title">Dear Mr.{{ Auth::user()->lastname }} <span class="invoice-date">{{ \Carbon\Carbon::now()->format('d M Y, H:i:s') }}</span></h3>
                            <p>Thank you for using FANEx. Your payment was done successfully. You have made the following payment to:</p>
                            <p class="invoice-bnf">John doe</p>

                            {{-- Invoice Table --}}
                            <div class="row m-0 p-0">
                                <div class="col-sm-12 col-md-8 col-md-push-2 invoice-factor">
                                <div class="col-xs-6 p-0 m-0 acc-info-left">
                                    <p class="table-header">Item</p>
                                    <p>Prem. Amount:</p>
                                    <p>Expense:</p>
                                    <p>Tax:</p>
                                    <hr>
                                    <p>Sum</p>
                                    <p>&nbsp;</p>
                                    <hr>
                                    <p class="orange">Transaction Reference No.</p>
                                    <p class="grey">Transaction Status</p>
                                </div>
                                <div class="col-xs-6 p-0 m-0 acc-info-right">
                                    <p class="table-header">Price</p>
                                    <p>3500 EUR</p>
                                    <p>15 EUR</p>
                                    <p>4.5 EUR</p>
                                    <hr>
                                    <p>3519.5 EUR</p>
                                    <p class="acc-factor-sum">= 95000000 Rials</p>
                                    <hr>
                                    <p class="orange">c56ds6a7658v987vdfb09</p>
                                    <p class="grey">Pending ...</p>
                                </div>
                            </div>
                            </div>

                            <div class="regards">
                                <p class="grey">Best Regards</p>
                                FANEx Team.
                                <a href="/" class="invoice-print" data-toggle="tooltip" title="Print The Invoice"><i class="icon-printer"></i></a>
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
                        <a href="/profile" class="btn fanexBtnOutlineGrey">All Transactions</a>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 5])
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