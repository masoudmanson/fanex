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
                    <div class="col-xs-9 px-0">
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

                    <div class="col-xs-3 px-0">
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
                                   placeholder="@lang('profile.bnfSearch')">
                            <div id="searchbox" class="panel-collapse collapse">
                                <div class="panel-body">
                                </div>
                            </div>
                        </div>
                        @foreach($beneficiaries as $bnf)
                            <div class="panel panel-default filtered ctr-{{ $bnf->country }}">
                                <div class="panel-heading">
                                    <div class="row p-0 m-0">
                                        <div class="col-md-3 col-sm-3 col-xs-5" data-toggle="tooltip"
                                             title="@lang('profile.bnfName')">
                                            <i class="icon-user acc-main-icon hidden-xs"></i>
                                            <span class="acc-user"><b>{{ $bnf->firstname . ' ' . $bnf->lastname }}</b></span>
                                        </div>
                                        <div class="col-md-2 col-sm-3 hidden-xs" data-toggle="tooltip"
                                             title="@lang('payment.bnfCC')">
                                            <span class="acc-date">{{ $bnf->account_number }}</span>
                                        </div>
                                        <div class="col-md-1 hidden-sm hidden-xs" data-toggle="tooltip"
                                             title="@lang('profile.bnfCountry')">
                                            <span class="acc-cash">{{ $countries[$bnf->country] }}</span>
                                        </div>
                                        <div class="col-md-2 hidden-sm hidden-xs" data-toggle="tooltip"
                                             title="@lang('payment.bnfPhone')">
                                            <span class="acc-date">{{ $bnf->tel }}</span>
                                        </div>
                                        <div class="col-md-3 col-sm-5 col-xs-6 px-0 bnf-action-icons">
                                            <a href="/send/{{ $bnf->id }}">
                                                <i class="icon-trans" title="@lang('profile.bnfSendMoney')"></i>
                                            </a>
                                            {{--<a href="/">--}}
                                            {{--<i class="icon-chat hidden-xs" title="@lang('profile.bnfSendMsg')"></i>--}}
                                            {{--</a>--}}
                                            <a href="/beneficiaries/{{ $bnf->id }}/edit">
                                                <i class="icon-edit" title="@lang('profile.bnfEdit')"></i>
                                            </a>
                                            <a href="">
                                                <i class="icon-delete" title="@lang('profile.bnfDelete')"></i>
                                            </a>
                                        </div>
                                        <a class="col-md-1 col-sm-1 col-xs-1 accordion-toggle" data-toggle="collapse"
                                           data-parent="#accordion" href="{{ "#row".$bnf->id }}">
                                            <span class="acc-arrow"></span>
                                        </a>
                                    </div>
                                </div>

                                <div id="{{ "row".$bnf->id }}" class="panel-collapse collapse">
                                    <div class="panel-body p-0">
                                        <div class="row m-0 p-0">
                                            <div class="col-sm-12 col-md-6 p-0 m-0">
                                                {{-- Beneficiary Name --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('profile.bnfName')">
                                                    <i class="icon-user bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-firstname">
                                                        {{ $bnf->firstname . ' ' . $bnf->lastname }}
                                                    </div>
                                                </div>

                                                {{--Country --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('profile.bnfCountry')">
                                                    <i class="icon-globe bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-country">
                                                        {{ $countries[$bnf->country] }}
                                                    </div>
                                                </div>

                                                {{-- Address --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfAddr')">
                                                    <i class="icon-globe bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-address">
                                                        @if($bnf->address) {{ $bnf->address }} @else  <span class="opacity-50 unselectable" unselectable="on">@lang('payment.bnfAddr')</span> @endif
                                                    </div>
                                                </div>

                                                {{-- Phone Number --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfPhone')">
                                                    <i class="icon-mobile bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-phone">
                                                        {{ $bnf->tel }}
                                                    </div>
                                                </div>

                                                {{--Fax Number --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfFax')">
                                                    <i class="icon-fax bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-fax">
                                                        @if($bnf->fax) {{ $bnf->fax }} @else  <span class="opacity-50 unselectable" unselectable="on">@lang('payment.bnfFax')</span> @endif
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- Left Column --}}
                                            <div class="col-sm-12 col-md-6 p-0 m-0">
                                                {{-- Bank Name --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfBank')">
                                                    <i class="icon-bank bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-bankname">
                                                        {{ $bnf->bank_name }}
                                                    </div>
                                                </div>

                                                {{-- Branch Address --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfBranch')">
                                                    <i class="icon-branch bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-branch">
                                                        {{ $bnf->branch_name }}
                                                    </div>
                                                </div>

                                                {{-- Account Number --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfCC')">
                                                    <i class="icon-card bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-accountnumber">
                                                        {{ $bnf->account_number }}
                                                    </div>
                                                </div>

                                                {{-- Swift Code --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfSwift')">
                                                    <i class="icon-swift bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-swift">
                                                        {{ $bnf->swift_code }}
                                                    </div>
                                                </div>

                                                {{-- iBan Number --}}
                                                <div class="form-group bsWrapper" data-toggle="tooltip"
                                                     title="@lang('payment.bnfIban')">
                                                    <i class="icon-code bsIcon"></i>
                                                    <div class="form-control fanexInput fanexInputPanel"
                                                         id="bnf-ajax-iban">
                                                        {{ $bnf->iban_code }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
        });
    </script>
@endsection