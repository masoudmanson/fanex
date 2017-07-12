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
                            <input type="text" class="panel-heading fanexInputWhite search-filter"
                                   placeholder="@lang('profile.bnfSearch')" id="beneficiary-search">
                            <div id="searchbox" class="panel-collapse collapse">
                                <div class="panel-body">
                                </div>
                            </div>
                        </div>
                        <br class="clear">

                        <div style="position: relative">
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
                    $('.filtered.ctr-' + filter).slideDown(200);
                }
            });

            $('#beneficiary-search').keyup(function (e) {
                if (x) {
                    x.abort()
                }
                var keyword = $(this).val();
                if (keyword.length == 0 || keyword.length >= 3) {
                    $('#mainFormLoader').fadeIn(200);
                    clearTimeout(timer);
                    timer = setTimeout(function () {
                        console.log('raft');
                        x = $.ajax({
                            method: 'get',
                            url: '/search/beneficiary',
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
                            if(keyword.length >= 3) {
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