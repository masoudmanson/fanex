@extends('layouts.master')

@section('styles')
    <style>
        a[title="Click to see this area on Google Maps"],
        .gm-style div a div img,
        .gm-style-cc,
        .gmnoprint {
            opacity: 0;
            display: none;
        }
        .bgWrapper {
            background-color: #333 !important;
        }
        @media only screen and (max-width: 1200px) {
            .bgDivLeft {
                display: none;
            }
        }
    </style>
@endsection

@section('header')
    @include('partials.nav')
@endsection

@section('content')
    <div class="bgWrapper">
        <div class="col-lg-6 col-md-12 bgDiv bgDivLeft"></div>
        <div class="col-lg-6 col-md-12 bgDiv bgDivRight p-0 m-0">
            {!! Mapper::render() !!}
        </div>
    </div>
    <div class="container-fluid indexWrapper">
        <div class="row m-0">
            {{-- Form Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                @include('partials.contactForm')
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="addressWrapper">
                    <h4>#123, 12th Noavari Ave, Pardis Tech Park, Tehran, Iran</h4>
                    <p><i class="icon-phone"></i> +98 21 7625 0515</p>
                    <p><i class="icon-fax"></i> +98 21 7625 0516</p>
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