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
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-1 col-sm-1 px-0">
                        <ul class="filter-ul">
                            <li class="filter-li"></li>
                        </ul>
                    </div>

                    <div class="col-xs-11 col-sm-11 px-0">
                        <ul class="filter-ul filter-right">
                            <li class="filter-li"><a href="/beneficiaries/add">Add New Beneficiary</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default pending">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip" title="Beneficiary Name">
                                        <i class="icon-user acc-main-icon"></i>
                                        <span class="acc-user"><b>Masoud Amjadi</b></span>
                                    </div>
                                    <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip" title="Beneficiary Account Number">
                                        <span class="acc-date">6104-3379-1254-3665</span>
                                    </div>
                                    <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip" title="Country">
                                        <span class="acc-cash">Iran</span>
                                    </div>
                                    <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip" title="Mobile Number">
                                        <span class="acc-date">09148401824</span>
                                    </div>
                                    <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                        <a href="/">
                                            <i class="icon-trans" title="Send Money"></i>
                                        </a>
                                        <a href="/">
                                            <i class="icon-chat hidden-xs" title="Send Message"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-edit"title="Edit Info"></i>
                                        </a>
                                        <a href="">
                                            <i class="icon-delete" title="Delete Beneficiary"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row1"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row1" class="panel-collapse collapse in">
                                <div class="panel-body p-0">
                                    <div class="row m-0 p-0">
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Beneficiary Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Name">
                                                <i class="icon-user bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-firstname">
                                                    Masoud Amjadi
                                                </div>
                                            </div>

                                            {{-- Account Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Account Number">
                                                <i class="icon-card bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-accountnumber">
                                                    6104337912543665
                                                </div>
                                            </div>

                                            {{-- Country --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Country">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-country">
                                                    Iran
                                                </div>
                                            </div>

                                            {{-- Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Beneficiary Address">
                                                <i class="icon-globe bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-address">#123, Noavari
                                                    12, Pardis Tech Park, Tehran
                                                </div>
                                            </div>

                                            {{-- Phone Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Mobile Number">
                                                <i class="icon-mobile bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-phone">09148401824
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Left Column --}}
                                        <div class="col-sm-12 col-md-6 p-0 m-0">
                                            {{-- Bank Name --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Bank Name">
                                                <i class="icon-bank bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-bankname">
                                                    Pasargad
                                                </div>
                                            </div>

                                            {{-- Branch Address --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Branch Address">
                                                <i class="icon-branch bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-branch">
                                                    #12, Pasargad 13, Africa Blv, Tehran, Iran
                                                </div>
                                            </div>

                                            {{-- Swift Code --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Swift Code">
                                                <i class="icon-swift bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-swift">
                                                    54584534468431346463131
                                                </div>
                                            </div>

                                            {{-- iBan Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="iBan Number">
                                                <i class="icon-code bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-iban">
                                                    4646464000011054048880
                                                </div>
                                            </div>

                                            {{-- Fax Number --}}
                                            <div class="form-group bsWrapper" data-toggle="tooltip" title="Fax Number">
                                                <i class="icon-fax bsIcon"></i>
                                                <div class="form-control fanexInput fanexInputPanel" id="bnf-ajax-fax">02171951111</div>
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