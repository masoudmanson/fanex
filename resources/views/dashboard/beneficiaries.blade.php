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
                    <div class="col-xs-7 px-0">
                        <ul class="filter-ul">
                            <li class="filter-li active" data-filter="all" style="margin-right: 5px;"><a href="#"><span
                                            class="mini-title">@lang('profile.filterAllShort')</span><span
                                            class="large-title">@lang('profile.filterAllShort')</span></a></li>
                            @foreach($filter_countries as $index => $country)
                                <li class="filter-li flag" data-filter="{{ $country }}"
                                    title="{{ $countries[$country] }}"><i
                                            class="flag-icon-squared flag-icon-{{ strtolower($country) }}"></i></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-xs-5 px-0">
                        <ul class="filter-ul filter-right">
                            <li class="filter-li-link"><a href="/beneficiaries/create">@lang('profile.addNew')</a></li>
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
                                               placeholder="@lang('profile.bnfSearch')"
                                               id="beneficiary-search">
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
                                            <li class="search-command" data-command="mobile:"><p>@lang('profile.srchHelpMobile')</p></li>
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
                            <div id="ajax-beneficiary-list">
                                @include('partials.beneficiaty-list-item', ['beneficiaries' => $beneficiaries, 'countries' => $countries])
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
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                getBeneficiaries($(this).attr('href'));
            });

            $('.filter-li').on('click', function() {
                $('#mainFormLoader').fadeIn(200);
                $('.filter-li').removeClass('active');
                $(this).addClass('active');
                var filter = $(this).attr('data-filter');
                var keyword = $('#beneficiary-search').val();
                getBeneficiaries('/search/beneficiary?page=1', keyword, filter);
            });

            $('#beneficiary-search').keyup(function(event) {
                if (event.which == 13 || event.keyCode == 13) {
                    searchBeneficiaries($(this).val());
                }
            });

            $('#search-button').on('click', function() {
                searchBeneficiaries($('#beneficiary-search').val());
            });
        });

        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getBeneficiaries(page);
                }
            }
        });

        function getBeneficiaries(url, keyword, country) {
            keyword = typeof keyword !== 'undefined' ? '&keyword=' + keyword : '';
            country = typeof country !== 'undefined' ? '&country=' + country : '';

            $('#mainFormLoader').fadeIn(200);
            $.ajax({
                url:  url + keyword + country,
                method: 'get',
                dataType: 'json',
            }).done(function (data) {
                $('#mainFormLoader').fadeOut(200);
                $('#ajax-beneficiary-list').html(data);
            }).fail(function () {
                console.log('Posts could not be loaded.');
            });
        }

        function searchBeneficiaries(keyword) {
            $('.filter-li').removeClass('active');
            $('#all-filter').addClass('active');

            if (keyword.length == 0) {
                $('#mainFormLoader').fadeIn(200);
                x = $.ajax({
                    method: 'get',
                    url: '/beneficiaries',
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                        document.getElementById('logout-form').submit();
                    },
                }).done(function(response) {
                    $('#mainFormLoader').fadeOut(200);
                    $('#ajax-beneficiary-list').html(response);
                });
            }
            else if (keyword.length >= 1) {
                $('#mainFormLoader').fadeIn(200);
                $.ajax({
                    method: 'post',
                    url: '/search/beneficiary',
                    data: {
                        '_token': csrfToken,
                        'X-CSRF-TOKEN': csrfToken,
                        'keyword': keyword,
                    },
                    success: function(response) {
                        $('#mainFormLoader').fadeOut(200);
                        $('#ajax-beneficiary-list').html(response);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                        document.getElementById('logout-form').submit();
                    },
                });
            }
        }

        function deleteBnf(bnf) {
            swal({
                title: '{{ __('js.swalTitleAreYouSure') }}',
                text: "{{ __('js.swalDeleteText') }}",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#F44336',
                confirmButtonText: '{{ __('js.swalDeleteYes') }}',
                cancelButtonText: '{{ __('js.swalDeleteNo') }}',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            method: 'DELETE',
                            url: '/beneficiaries/' + bnf,
                            data: {
                                '_token': csrfToken,
                                'X-CSRF-TOKEN': csrfToken
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal(
                                    '{{ __('js.swalErrorTitle') }}',
                                    '{{ __('js.swalErrorText') }}',
                                    'error'
                                )
                            }
                        }).done(function (response) {
                            $('#bnf-' + bnf).slideUp();
                            swal(
                                '{{ __('js.swalDeleted') }}',
                                '{{ __('js.swalDeletedText') }}',
                                'success'
                            );
                        });
                    })
                }
            });
        }
    </script>
@endsection