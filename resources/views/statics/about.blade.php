@extends('layouts.master')

@section('styles')
    <style>
        .bgWrapper {
            background-color: #333 !important;
        }
        .bgDiv i::before {
            color: rgba(0, 0, 0, 0.3);
            font-size: 600px;
            position: absolute;
            margin: auto;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            vertical-align: middle;
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
            <i class="icon-about"></i>
        </div>
    </div>
    <div class="container-fluid indexWrapper">
        <div class="row m-0">
            {{-- Form Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                @include('partials.mainForm', ['country_list'=>$country_list, 'beneficiary' => null])
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="staticHeader">
                    <p class="fanexLogoName">@lang('index.about')</p>
                    <div class="fanexMotto">@lang('index.aboutText')</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#main-content-wrapper').css({'padding-bottom':0});
        });
    </script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection