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
            @include('partials.profileSidebar', ["page" => "notifications"])

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0" style="margin-top: 30px;">
                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row p-0 m-0">
                                    <div class="col-md-4 col-sm-6 col-xs-9" data-toggle="tooltip" title="@lang('profile.ntfTitle')">
                                        <i class="icon-chat acc-main-icon"></i>
                                        <span class="acc-user"><b>@lang('profile.ntfSucc')</b></span>
                                    </div>
                                    <div class="col-md-3 col-sm-4 hidden-xs" data-toggle="tooltip" title="@lang('profile.ntfSender')">
                                        <span class="acc-cash">@lang('profile.ntfFanex')</span>
                                    </div>
                                    <div class="col-md-3 hidden-sm hidden-xs" data-toggle="tooltip" title="@lang('profile.ntfTime')">
                                        <span class="acc-date">{{ \Carbon\Carbon::now()->format("d M Y, H:i:s") }}</span>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-2 px-0 bnf-action-icons">
                                        <a href="">
                                            <i class="icon-delete" title="@lang('profile.ntfDelete')"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row1"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row1" class="panel-collapse collapse in">
                                <div class="panel-body no-border notification-body">
                                    <div class="row">
                                        <div class="col-xs-12 px-5">
                                            <p>@lang('profile.ntfLorem')</p>
                                            <a href="/" class="notification-link">@lang('profile.ntfAttach') <i class="icon-download"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading new">
                                <div class="row p-0 m-0">
                                    <div class="col-md-4 col-sm-6 col-xs-9" data-toggle="tooltip" title="@lang('profile.ntfTitle')">
                                        <i class="icon-chat acc-main-icon"></i>
                                        <span class="acc-user"><b>Puleto Rikhtam :V</b></span>
                                    </div>
                                    <div class="col-md-3 col-sm-4 hidden-xs" data-toggle="tooltip" title="@lang('profile.ntfSender')">
                                        <span class="acc-cash">Emad Ghorbani Nia</span>
                                    </div>
                                    <div class="col-md-3 hidden-sm hidden-xs" data-toggle="tooltip" title="@lang('profile.ntfTime')">
                                        <span class="acc-date">{{ \Carbon\Carbon::now()->format("d M Y, H:i:s") }}</span>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-2 px-0 bnf-action-icons">
                                        <a href="">
                                            <i class="icon-delete" title="@lang('profile.ntfDelete')"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <span class="acc-arrow accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#row2"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="row2" class="panel-collapse collapse">
                                <div class="panel-body no-border notification-body">
                                    <div class="row">
                                        <div class="col-xs-12 px-5">
                                            <p>@lang('profile.ntfLorem')</p>
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

            $('#accordion').on('shown.bs.collapse', function() {
                var heading = $(this).find('.panel-heading');
                heading.removeClass('new');
            });
        });
    </script>
@endsection