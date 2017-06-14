@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>Receipt</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-xs-12 p-0">
                        <h2 class="dash-subtitle">Your Payment Transaction has Ended</h2>
                        <div class="invoice-wrapper mb-4">
                            <h3 class="invoice-title">Dear Mr.{{ Auth::user()->lastname }} <span class="invoice-date">{{ \Carbon\Carbon::now()->format('d M Y, H:i:s') }}</span></h3>
                            <p>Thank you for using FANEx. Your payment was done successfully. You have made the following payment to:</p>
                            <p class="invoice-bnf">John doe</p>

                            {{-- Invoice Table --}}
                            <div class="row m-0 p-0">
                                <ul class="col-sm-12 col-md-8 col-md-push-2 invoice-factor">
                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0">
                                            <p class="table-header">Item</p>
                                        </div>
                                        <div class="hidden-xs col-sm-6 p-0 m-0">
                                            <p class="table-header">Cost</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>Prem. Amount:</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>3500 EUR</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>Expense:</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>15 EUR</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>Tax:</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>4.5 EUR</p>
                                        </div>
                                    </li>

                                    <hr>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p>Sum</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p>3519.5 EUR</p>
                                            <p class="acc-factor-sum">= 95000000 Rials</p>
                                        </div>
                                    </li>

                                    <hr>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="orange">Transaction Reference No.</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="orange">c56ds6a7658v987vdfb09</p>
                                        </div>
                                    </li>

                                    <li class="row m-0">
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-left">
                                            <p class="grey">Transaction Status</p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 p-0 m-0 acc-info-right">
                                            <p class="grey">Pending ...</p>
                                        </div>
                                    </li>
                                {{--<div class="col-xs-6 p-0 m-0 acc-info-left">--}}
                                    {{--<p class="table-header">Item</p>--}}
                                    {{--<p>Prem. Amount:</p>--}}
                                    {{--<p>Expense:</p>--}}
                                    {{--<p>Tax:</p>--}}
                                    {{--<hr>--}}
                                    {{--<p>Sum</p>--}}
                                    {{--<p>&nbsp;</p>--}}
                                    {{--<hr>--}}
                                    {{--<p class="orange">Trnas. Ref. No.</p>--}}
                                    {{--<p class="grey">Trans. Status</p>--}}
                                {{--</div>--}}
                                {{--<div class="col-xs-6 p-0 m-0 acc-info-right">--}}
                                    {{--<p class="table-header">Cost</p>--}}
                                    {{--<p>3500 EUR</p>--}}
                                    {{--<p>15 EUR</p>--}}
                                    {{--<p>4.5 EUR</p>--}}
                                    {{--<hr>--}}
                                    {{--<p>3519.5 EUR</p>--}}
                                    {{--<p class="acc-factor-sum">= 95000000 Rials</p>--}}
                                    {{--<hr>--}}
                                    {{--<p class="orange">c56ds6a7658v987vdfb09</p>--}}
                                    {{--<p class="grey">Pending ...</p>--}}
                                {{--</div>--}}
                            </ul>
                            </div>

                            <div class="regards">
                                <p class="grey">Best Regards</p>
                                FANEx Team.
                                <a href="/" class="invoice-print" data-toggle="tooltip" title="Print The Invoice"><i class="icon-printer"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <a href="/" class="btn fanexBtnNoline">Back Home</a>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        <a href="/profile" class="btn fanexBtnOutlineGrey">All Transactions</a>
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
        $(document).ready(function () {

        });
    </script>
@endsection