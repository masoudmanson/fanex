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
            @include('partials.profileSidebar', ["page" => "transactions"])

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0">
                <div class="row p-0 m-0 filter-wrapper">
                    <div class="col-xs-9 col-sm-9 px-0">
                        {{-- Filter List --}}
                        <ul class="filter-ul">
                            <li class="filter-li active" data-filter="all"><a href="#"><span
                                            class="mini-title">@lang('profile.filterAll')</span><span
                                            class="large-title"><i>@lang('profile.filterAllShort')</i></span></a></li>
                            <li class="filter-li" data-filter="successful"><a href="#"><span
                                            class="mini-title">@lang('profile.filterSucc')</span><span
                                            class="large-title"><i class="icon-check"></i></span></a></li>
                            <li class="filter-li" data-filter="waiting"><a href="#"><span
                                            class="mini-title">@lang('profile.filterPend')</span><span
                                            class="large-title"><i class="icon-pending"></i></span></a></li>
                            <li class="filter-li" data-filter="failed"><a href="#"><span
                                            class="mini-title">@lang('profile.filterFail')</span><span
                                            class="large-title"><i class="icon-close"></i></span></a></li>
                        </ul>
                    </div>

                    <div class="col-xs-3 col-sm-3 px-0">
                        <ul class="filter-ul filter-right">
                            <li class="filter-li-link"><a href={{ route('index') }}><span
                                            class="mini-title">@lang('profile.newTrans')</span><span
                                            class="large-title">@lang('profile.newTransShort')</span></a></li>
                        </ul>
                    </div>
                </div>
                <br class="clear">

                {{-- Table Wrapper --}}
                <div class="row p-0 m-0">
                    <div class="panel-group" id="accordion">
                        {{-- Search Box --}}
                        <div class="panel panel-default search" id="search-input">
                            <input type="text" class="panel-heading fanexInputWhite search-filter"
                                   placeholder="@lang('profile.searchHolder')" id="transaction-search">
                            <div id="searchbox" class="panel-collapse collapse">
                            </div>
                        </div>

                        <div style="position: relative; margin-top: 15px;">
                            {{-- Form Loading Container --}}
                            <div id="mainFormLoader" style="display:none;">
                                <div class="errors" style="display: none"></div>
                                <div class="spinner2">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                            <div id="ajax-beneficiary-list">
                                @include('partials.transaction-list-item', ['transactions' => $transactions])
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
        var timer;
        var x;

        $(document).ready(function () {
            $('.filter-li').on('click', function () {
                $('.filter-li').removeClass('active');
                $(this).addClass('active');
                var filter = $(this).attr('data-filter');
                if (filter == 'all') {
                    $('.filtered').slideDown(200);
                }
                else {
                    $('.filtered').slideUp(200);
                    $('.filtered.' + filter).slideDown(200);
                }
            });


            $('#transaction-search').keyup(function (e) {
                if (x) {
                    x.abort()
                }
                var keyword = $(this).val();
                if (keyword.length == 0 || keyword.length >= 2) {
                    $('#mainFormLoader').fadeIn(200);
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        console.log('Searching for: "'+keyword+'"');
                        x = $.ajax({
                            method: 'get',
                            url: '/search/transaction',
                            data: {
                                '_token': csrfToken,
                                'X-CSRF-TOKEN': csrfToken,
                                "keyword": keyword,
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        }).done(function (response) {
                            $('#mainFormLoader').fadeOut(200);
                            if(keyword.length >= 2) {
                                keyword = keyword.replace(/(\s+)/, "(<[^>]+>)*$1(<[^>]+>)*");
                                var pattern = new RegExp("(" + keyword + ")", "gi");

                                response = response.replace(pattern, "<mark>$1</mark>");
                                response = response.replace(/(<mark>[^<>]*)((<[^>]+>)+)([^<>]*<\/mark>)/, "$1</mark>$2<mark>$4");
                            }
                            $('#ajax-beneficiary-list').html(response);
                        });
                    }, 1500);
                }
            });
        });
    </script>
@endsection