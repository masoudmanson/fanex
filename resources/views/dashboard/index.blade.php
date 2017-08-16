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
                            <div class="panel-heading p-0 m-0">
                                <div class="row p-0 m-0">
                                    <div class="col-xs-2 col-sm-1">
                                        <a class="accordion-toggle" id="search-button"></a>
                                    </div>

                                    <div class="col-xs-8 col-sm-10">
                                        <input type="text"
                                               class="fanexInputWhite noShadow search-filter p-0 search-input"
                                               placeholder="@lang('profile.searchHolder')"
                                               id="transaction-search">
                                    </div>

                                    <div class="col-xs-2 col-sm-1">
                                        <a class="accordion-toggle status-handler help-link collapsed"
                                           data-toggle="collapse"
                                           data-parent="#search-input"
                                           href="#searchbox">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div id="searchbox" class="panel-collapse collapse">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h5 class="text-info">@lang('profile.srchHelpTitle')
                                            <small>@lang('profile.srchHelpText')</small>
                                        </h5>
                                        <ul>
                                            <li class="search-command" data-command="name:"><p>@lang('profile.srchHelpName')</p></li>
                                            <li class="search-command" data-command="account:"><p>@lang('profile.srchHelpAccount')</p></li>
                                            <li class="search-command" data-command="transaction:"><p>@lang('profile.srchHelpTransaction')</p></li>
                                            <li class="search-command" data-command="amount:"><p>@lang('profile.srchHelpAmount')</p></li>
                                            {{--<li class="search-command" data-command="date:"><p>@lang('profile.srchHelpDate')</p></li>--}}
                                        </ul>
                                        <br>
                                        <p class="tip">@lang('profile.srchHelpTip1')</p>
                                        <p class="tip">@lang('profile.srchHelpTip2')</p>
                                        <p class="tip">@lang('profile.srchHelpTip3')</p>
                                    </div>
                                </div>
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
                            <div id="ajax-transaction-list">
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
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                getBeneficiaries($(this).attr('href'));
            });

            $('.filter-li').on('click', function() {
                $('#transaction-search').val('');
                $('#mainFormLoader').fadeIn(200);
                $('.filter-li').removeClass('active');
                $(this).addClass('active');
                var filter = $(this).attr('data-filter');
                $.ajax({
                    method: 'get',
                    url: '/search/transaction/status/' + filter,
                    data: {
                        '_token': csrfToken,
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    },
                }).done(function(response) {
                    $('#mainFormLoader').fadeOut(200);
                    $('#ajax-transaction-list').html(response);
                });
            });

            $('#transaction-search').keyup(function(event) {
                if (event.which == 13 || event.keyCode == 13) {
                    search($(this).val());
                }
            });

            $('#search-button').on('click', function() {
                search($(this).val());
            });
        });

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                }
                else {
                    getBeneficiaries(page);
                }
            }
        });

        function getBeneficiaries(url) {
            var keyword = $('#transaction-search').val();

            $('#mainFormLoader').fadeIn(200);
            $.ajax({
                url: url,
                dataType: 'json',
            }).done(function(data) {
                $('#mainFormLoader').fadeOut(200);
                if (keyword.length > 0) {
                    keyword = keyword.replace(/(\s+)/, '(<[^>]+>)*$1(<[^>]+>)*');
                    var pattern = new RegExp('([^\/])(' + keyword + ')([^\?])', 'gi');
                    data = data.replace(pattern, '$1<mark>$2</mark>$3');
                    data = data.replace(/(<mark>[^<>]*)((<[^>]+>)+)([^<>]*<\/mark>)/, '$1</mark>$2<mark>$4');
                }
                $('#ajax-transaction-list').html(data);
            }).fail(function() {
                console.log('Posts could not be loaded.');
            });
        }
    </script>
@endsection