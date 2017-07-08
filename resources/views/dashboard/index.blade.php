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
                                   placeholder="@lang('profile.searchHolder')">
                            <div id="searchbox" class="panel-collapse collapse">
                            </div>
                        </div>
                        @foreach($transactions as $transaction)
                            <div class="panel panel-default filtered {{ $transaction->upt_status }}">
                                <div class="panel-heading @if(!$transaction->uri || !$transaction->payment_date) new @endif">
                                    <div class="row p-0 m-0">
                                        <div class="col-md-4 col-sm-4 col-xs-5" data-toggle="tooltip"
                                             title="@lang('profile.titleTransfer')">
                                            <i class="icon-trans acc-main-icon hidden-xs"></i>
                                            <span class="acc-user">
                                                <span class="hidden-sm hidden-xs">@lang('profile.titleTransfer') </span>
                                                <b>{{ $transaction->beneficiary->firstname . ' ' . $transaction->beneficiary->lastname }}</b>
                                            </span>
                                        </div>
                                        <div class="col-md-2 hidden-xs hidden-sm" data-toggle="tooltip"
                                             @if($transaction->uri && $transaction->payment_date) title="@lang('profile.titleDate')" @endif>
                                            <span class="acc-date">
                                                @if($transaction->uri && $transaction->payment_date)
                                                    @lang('payment.invDate', ['dateEn' => $transaction->payment_date->format('d M Y'), 'dateFa' => jdate($transaction->payment_date)->format('%Y %B %d')])
                                                @else
                                                    <a href="{{ route('index') }}" class="btn btnMini btnRound fanexBtnMiniOutlineGrey">@lang('index.pay')</a>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-2 col-sm-3 col-xs-3" data-toggle="tooltip"
                                             title="@lang('profile.titleAmount')">
                                            <span class="acc-cash">{{ number_format($transaction->premium_amount).' &lrm;'. $transaction->currency }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-3 col-xs-2" data-toggle="tooltip"
                                             title="@lang('profile.titleStatus')">
                                        <span class="acc-status fanex-text-{{ $transaction->upt_status }}">
                                            <i class="icon-{{ $transaction->upt_status }}"></i>
                                            <span class="hidden-xs">@lang('profile.'.$transaction->upt_status)</span>
                                        </span>
                                        </div>
                                        <div class="col-md-1 col-sm-1 hidden-xs" data-toggle="tooltip"
                                             title="@lang('profile.titleToAcc')">
                                        <span class="acc-type">
                                            <i class="icon-reciept"></i>
                                        </span>
                                        </div>
                                        <a class="col-md-1 col-sm-1 col-xs-2 accordion-toggle" data-toggle="collapse"
                                           data-parent="#accordion" href="#row{{ $transaction->id }}"
                                           data-target="#row{{ $transaction->id }}">
                                            <span class="acc-arrow"></span>
                                        </a>
                                    </div>
                                </div>
                                <div id="row{{ $transaction->id }}" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row m-0 p-0">
                                            <div class="col-sm-12 col-md-7">
                                                <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                    <p>@lang('profile.tableTransNo')</p>
                                                    <p>@lang('profile.tableBnfAcc')</p>
                                                    <p>@lang('profile.tableBank')</p>
                                                    <p>@lang('profile.tableDate')</p>
                                                    <p>@lang('profile.tableType')</p>
                                                    <p class="grey">@lang('payment.invBankStatus')</p>
                                                    <p class="grey">@lang('payment.invFanexStatus')</p>
                                                    <p class="grey">@lang('payment.invUptStatus')</p>
                                                </div>
                                                <div class="col-xs-7 p-0 m-0 acc-info-right">

                                                    @if($transaction->uri)
                                                        <p>{{ $transaction->uri }}</p>
                                                    @else
                                                        <p>-</p>
                                                    @endif

                                                    <p>{{ $transaction->beneficiary->account_number }}</p>
                                                    <p>{{ $transaction->beneficiary->bank_name }}</p>

                                                    @if($transaction->uri && $transaction->payment_date)
                                                        <p>@lang('payment.invDate', ['dateEn' => $transaction->payment_date->format('d M Y, H:i:s'), 'dateFa' => jdate($transaction->payment_date)->format('%Y %B %d, H:i:s')])</p>
                                                    @else
                                                        <p>@lang('profile.waiting')</p>
                                                    @endif

                                                    <p>@lang('profile.titleToAcc')</p>
                                                    <p class="fanex-text-{{ $transaction->bank_status }}">@lang('profile.'.$transaction->bank_status)</p>
                                                    <p class="fanex-text-{{ $transaction->fanex_status }}">@lang('profile.'.$transaction->fanex_status)</p>
                                                    <p class="fanex-text-{{ $transaction->upt_status }}">@lang('profile.'.$transaction->upt_status)
                                                        (@lang('payment.invDate', ['dateEn' => $transaction->updated_at->format('d M Y, H:i:s'), 'dateFa' => jdate($transaction->updated_at)->format('%Y %B %d, H:i:s')])
                                                        )</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-5 acc-factor">
                                                <div class="col-xs-5 p-0 m-0 acc-info-left">
                                                    <p class="table-header">@lang('payment.invItem')</p>
                                                    <p>@lang('payment.invAmount')</p>
                                                    <p>@lang('payment.invExp')</p>
                                                    <p>@lang('payment.invTax')</p>
                                                    <hr>
                                                    <p>@lang('payment.invSum')</p>
                                                </div>
                                                <div class="col-xs-7 p-0 m-0 acc-info-right">
                                                    <p class="table-header">@lang('payment.invCost')</p>
                                                    <p>{{ number_format($transaction->premium_amount, 0) . ' ' . $transaction->currency }}</p>
                                                    <p>0</p>
                                                    <p>{{ number_format($transaction->vat) }} @lang('index.formRials')</p>
                                                    <hr>
                                                    <p>{{ number_format($transaction->premium_amount, 0) . ' ' . $transaction->currency . ' + &rlm;' . number_format($transaction->vat) }} @lang('index.formRials')</p>
                                                    <p class="acc-factor-sum">
                                                        = {{ number_format($transaction->payment_amount+$transaction->vat) }} @lang('payment.invRials')</p>
                                                </div>

                                                @if(!$transaction->uri)
                                                    <a href="{{ route('index') }}" class="hidden-md hidden-lg btn btnMini btnRound fanexBtnMiniOutlineOrange">@lang('index.pay')</a>
                                                @endif
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
                    $('.filtered.' + filter).slideDown(200);
                }
            });
        });
    </script>
@endsection