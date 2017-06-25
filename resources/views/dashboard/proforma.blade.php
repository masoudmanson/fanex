@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>@lang('payment.prfTitle')</b></h1>

            {{-- Beneficiary Info Form Container --}}
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0">
                    {{-- Create a New Benificiary --}}
                    <div class="col-xs-12 p-0">
                        <h2 class="dash-subtitle">@lang('payment.prfSubtitle')</h2>
                        <div class="proforma-wrapper mb-4">
                            <img src="{{ asset('css/images/proforma.png') }}" alt="@lang('payment.prfTitle')" style="width:100%; height: 100%;">
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <a href="{{ URL::previous() }}" class="btn fanexBtnNoline">@lang('payment.prfBack')</a>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        {{--<input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn"--}}
                        {{--value="Show Proforma"/>--}}
                        <form action="/invoice" method="get">

                            {{--<a href="/invoice" class="btn fanexBtnOutlineGrey">@lang('payment.prfPay')</a>--}}
                            <input type="hidden" value="" name="">
                            <input type="submit"  class="btn fanexBtnOutlineGrey" value="@lang('payment.prfPay')">
                        </form>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 4])
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