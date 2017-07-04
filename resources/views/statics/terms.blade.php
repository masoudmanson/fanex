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
                @include('partials.mainForm', ['beneficiary'=>null])
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="staticHeader">
                    <p class="fanexLogoName">@lang('index.termsTitle')</p>
                    <div class="fanexMotto">
                        <p>@lang('index.termsText')</p>
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