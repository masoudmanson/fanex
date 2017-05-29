@extends('layouts.master')

@section('styles')
    <style>
        .bgWrapper {
            background-color: #333 !important;
        }

        .bgDiv i::before {
            color: rgba(0, 0, 0, 0.3);
            font-size: 1100px;
            position: absolute;
            margin: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            vertical-align: middle;
            z-index: -1;
        }
    </style>
@endsection

@section('header')
    @include('partials.nav')
@endsection

@section('content')
    <div class="bgWrapper">
        <div class="col-lg-6 col-md-12 bgDiv bgDivLeft"></div>
        <div class="col-lg-6 col-md-12 bgDiv bgDivRight">
            <i class="icon-agreement"></i>
        </div>
    </div>
    <div class="container-fluid indexWrapper">
        <div class="row m-0">
            {{-- Form Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                @include('partials.mainForm')
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="staticHeader">
                    <p class="fanexLogoName">Terms of Use</p>
                    <div class="fanexMotto">
                        <p>Incorrect or incomplete information due to UPT process is done incorrectly, or the buyer does
                            not know the IBAN number for UPT operation is subject to the amount not received by the
                            recipient related to damages resulting from any of the Bank's responsibility to declare and
                            agree. The sender or recipient of information by public institutions in Turkey and abroad
                            published the banned people/countries to be in the list, the sender or the receipent taken
                            by the authorities about the implementation of the injunction, or other similar reasons UPT
                            operation amount is subject to processing by the correspondent bank, and shall be seized, to
                            the buyer in case of non-payment, your Bank of any responsibility to declare and agree. The
                            form of the descriptions I read, I accept and acknowledge that information is accurate and
                            complete. The bank will establish my communication, all of the legal cell phone number on
                            this form of acceptance and the use of declare. I ordered amount, recipient information, and
                            kindly mentioned form of the transfer in accordance with the payment method.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection