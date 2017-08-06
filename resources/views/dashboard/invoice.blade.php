@extends('layouts.master')

@section('styles')
@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')

    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>@lang('payment.invTitle')</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-xs-12 p-0">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <h2 class="alert alert-danger">{{ $error }}</h2>
                            @endforeach
                        @else
                            <h2 class="alert alert-success">@lang('payment.invSubtitle')</h2>
                        @endif
                        <div class="invoice-wrapper mb-4" id="pdfWrapper">
                            <h3 class="invoice-title">@lang('payment.invUser', ['user' => Auth::user()->firstname])
                                <span class="invoice-date">@lang('payment.invDate', ['dateEn' => $transaction->payment_date->format('d M Y, H:i:s'), 'dateFa' => jdate($transaction->payment_date)->format('%Y %B %d, H:i:s')])</span>
                            </h3>
                            <p>@lang('payment.invText', ['name' => $transaction->beneficiary->firstname . ' ' . $transaction->beneficiary->lastname])</p>

                            {{-- Invoice Table --}}
                            <div class="row m-0 p-0">
                                <ul class="col-sm-12 col-md-8 col-md-push-2 invoice-factor">
                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0">
                                            <p class="table-header">@lang('payment.invItem')</p>
                                        </div>
                                        <div class="hidden-xs col-sm-6 p-0 m-0">
                                            <p class="table-header">@lang('payment.invCost')</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>@lang('payment.invAmount')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>{{ number_format($transaction->premium_amount, 2) . ' ' . $transaction->currency }}</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>@lang('payment.invExp')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>0 @lang('index.formRials')</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>@lang('payment.invTax')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>{{ number_format($invoice_result->vat) }} @lang('index.formRials')</p>
                                        </div>
                                    </li>

                                    <hr>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>@lang('payment.invSum')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>{{ number_format($transaction->premium_amount, 2) . ' ' . $transaction->currency . ' + &rlm;' . number_format($invoice_result->vat) }} @lang('index.formRials')</p>
                                            <p class="acc-factor-sum">
                                                = {{ number_format($invoice_result->payableAmount) }} @lang('payment.invRials')</p>
                                        </div>
                                    </li>

                                    <hr>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="orange">@lang('payment.invTrans')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="orange">{{ $transaction->uri }}</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="grey">@lang('payment.invBankStatus')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="fanex-text-{{ $transaction->bank_status }}">@lang('profile.'.$transaction->bank_status)</p>
                                        </div>
                                    </li>
                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="grey">@lang('payment.invFanexStatus')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="fanex-text-{{ $transaction->fanex_status }}">@lang('profile.'.$transaction->fanex_status)</p>
                                        </div>
                                    </li>
                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="grey">@lang('payment.invUptStatus')</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="fanex-text-{{ $transaction->upt_status }}">@lang('profile.'.$transaction->upt_status)</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="regards">
                                <p class="grey">@lang('payment.invRegards')</p>
                                <i class="icon-fanex team"></i>
                                <a href="#" class="invoice-print" data-toggle="tooltip" id="print-pdf"
                                   title="@lang('payment.print')">
                                    <i class="icon-printer"></i>
                                    <span>@lang('payment.print')</span>
                                </a>
                            </div>
                            <br><br>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <a href="/" class="btn fanexBtnNoline">@lang('payment.backHome')</a>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        <a href="/profile" class="btn fanexBtnOutlineGrey">@lang('payment.invAll')</a>
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
        // Countdown Rates Exiration Time
        var finish = {{ $finish_time }};
        countdown(finish);
    </script>
@endsection