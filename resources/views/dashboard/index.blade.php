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
            @include('partials.profileSidebar')

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-9 col-sm-9 px-0">
                        <ul class="filter-ul">
                            <li class="filter-li active"><a href="#"><span class="mini-title">All Transactions</span><span class="large-title">All</span></a></li>
                            <li class="filter-li"><a href="#"><span class="mini-title">Successful</span><span class="large-title"><i class="icon-check"></i></span></a></li>
                            <li class="filter-li"><a href="#"><span class="mini-title">Pending</span><span class="large-title"><i class="icon-pending"></i></span></a></li>
                            <li class="filter-li"><a href="#"><span class="mini-title">Failed</span><span class="large-title"><i class="icon-close"></i></span></a></li>
                        </ul>
                    </div>

                    <div class="col-xs-3 col-sm-3 px-0">
                        <ul class="filter-ul filter-right">
                            <li class="filter-li"><a href="/"><span class="mini-title">New Transactions</span><span class="large-title">New</span></a></li>
                        </ul>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default pending">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-sm-4 col-xs-5" data-toggle="tooltip" title="Transferred to">
                                        <i class="icon-trans acc-main-icon"></i>
                                        <span class="acc-user"><span class="hidden-xs">Transferred to </span><b>Masoud Amjadi</b></span>
                                    </div>
                                    <div class="col-sm-2 hidden-xs" data-toggle="tooltip" title="Transaction Date">
                                        <span class="acc-date">6 May 2017</span>
                                    </div>
                                    <div class="col-sm-2 col-xs-2" data-toggle="tooltip" title="Transferred Amount">
                                        <span class="acc-cash">5000 EUR</span>
                                    </div>
                                    <div class="col-sm-2 col-xs-3" data-toggle="tooltip" title="Transfer Status">
                                        <div class="acc-status pending">
                                            <i class="icon-pending"></i>
                                            Pending
                                        </div>
                                    </div>
                                    <div class="col-sm-1 hidden-xs" data-toggle="tooltip" title="Transfer To Account">
                                        <span class="acc-type">
                                            <i class="icon-reciept"></i>
                                        </span>
                                    </div>
                                    <div class="col-sm-1 col-xs-2">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row1"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p>Trans. No.:</p>
                                                <p>Bnf. Acc. No.:</p>
                                                <p>Bank Name:</p>
                                                <p>Payment Date:</p>
                                                <p>Trans. Status:</p>
                                                <p>Trans. Type:</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p>v8845ewf1w23fwefwe</p>
                                                <p>6104337912543665</p>
                                                <p>Pasargad</p>
                                                <p>{{ \Carbon\Carbon::now()->format("d M Y, H:s:i") }}</p>
                                                <p>Pending</p>
                                                <p>Transfer To Account</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5 acc-factor">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p># Item</p>
                                                <hr>
                                                <p>Premium Amount:</p>
                                                <p>Expense:</p>
                                                <p>Tax:</p>
                                                <hr>
                                                <p>Sum</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p>Price</p>
                                                <hr>
                                                <p>5000 EUR</p>
                                                <p>15 EUR</p>
                                                <p>4.5 EUR</p>
                                                <hr>
                                                <p>5019.5 EUR</p>
                                                <p class="acc-factor-sum">= 155000000 Rials</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default successful">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-sm-4 col-xs-5" data-toggle="tooltip" title="Transferred to">
                                        <i class="icon-trans acc-main-icon"></i>
                                        <span class="acc-user"><span class="hidden-xs">Transferred to </span><b>Emad Ghorbani Nia</b></span>
                                    </div>
                                    <div class="col-sm-2 hidden-xs" data-toggle="tooltip" title="Transaction Date">
                                        <span class="acc-date">25 January 2017</span>
                                    </div>
                                    <div class="col-sm-2 col-xs-2" data-toggle="tooltip" title="Transferred Amount">
                                        <span class="acc-cash">500 EUR</span>
                                    </div>
                                    <div class="col-sm-2 col-xs-3" data-toggle="tooltip" title="Transfer Status">
                                        <div class="acc-status successful">
                                            <i class="icon-check"></i>
                                            Successful
                                        </div>
                                    </div>
                                    <div class="col-sm-1 hidden-xs" data-toggle="tooltip" title="Cash Transfer">
                                        <span class="acc-type">
                                            <i class="icon-wallet"></i>
                                        </span>
                                    </div>
                                    <div class="col-sm-1 col-xs-2">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row2"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-7">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p>Trans. No.:</p>
                                                <p>Bnf. Acc. No.:</p>
                                                <p>Bank Name:</p>
                                                <p>Payment Date:</p>
                                                <p>Trans. Status:</p>
                                                <p>Trans. Type:</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p>v8845ewf1w23fwefwe</p>
                                                <p>6104337912543665</p>
                                                <p>Pasargad</p>
                                                <p>{{ \Carbon\Carbon::now()->format("d M Y, H:s:i") }}</p>
                                                <p>Pending</p>
                                                <p>Transfer To Account</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-5 acc-factor">
                                            <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                <p># Item</p>
                                                <hr>
                                                <p>Premium Amount:</p>
                                                <p>Expense:</p>
                                                <p>Tax:</p>
                                                <hr>
                                                <p>Sum</p>
                                            </div>
                                            <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                <p>Price</p>
                                                <hr>
                                                <p>5000 EUR</p>
                                                <p>15 EUR</p>
                                                <p>4.5 EUR</p>
                                                <hr>
                                                <p>5019.5 EUR</p>
                                                <p class="acc-factor-sum">= 155000000 Rials</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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