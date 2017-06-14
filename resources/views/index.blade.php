@extends('layouts.master')

@section('styles')
    <script src="{{ asset('js/ammap.js') }}"></script>
    <script src="{{ asset('js/worldHigh.js') }}"></script>
    <script src="{{ asset('js/black.js') }}"></script>
    <script src="{{ asset('js/export.min.js') }}"></script>
@endsection

@section('header')
    @include('partials.nav')
@endsection

@section('content')
    <div class="bgWrapper">
        <div class="col-lg-6 col-md-12 bgDiv bgDivLeft"></div>
        <div class="col-lg-6 col-md-12 bgDiv bgDivRight"></div>
    </div>
    <div class="container-fluid indexWrapper">
        <div class="row m-0">
            {{-- Form Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                @include('partials.mainForm')
            </div>

            {{-- Map and Static Pages Container --}}
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div class="mottoWrapper">
                    <p class="fanexLogoName">@lang('index.fanex')</p>
                    <p class="fanexMotto">@lang('index.motto')</p>
                </div>

                <div id="mapWrapper">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer')
@endsection

@section('scripts')
    {{--<script src="{{ asset('js/index.js') }}"></script>--}}
    <script>
        var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";
        var map = AmCharts.makeChart("mapWrapper", {
            "type": "map",
            "theme": "black",
            "projection": "miller",
            "dataProvider": {
                "map": "worldHigh",
                "zoomLevel": 1,
                "areas": [{
                    "title": "@lang('index.iran')",
                    "id": "IR",
                    "showAsSelected": true
                }, {
                    "title": "@lang('index.turkey')",
                    "id": "TR",
                    "showAsSelected": true
                }, {
                    "title": "@lang('index.usa')",
                    "id": "US",
                    "showAsSelected": true
                }],
            },
            "balloon": {
                "color": "#000000",
                "borderColor": "#000000",
                "fillColor": "#FFFFFF"
            },
            "areasSettings": {
                "unlistedAreasColor": "#000",
                "unlistedAreasAlpha": 0.08,
                "unlistedAreasOutlineAlpha": 0.02,
                "selectedColor": "#000",
                "rollOverColor": "#FFFFFF",
                "outlineAlpha": "0",
                "alpha": 0.2
            },
            "imagesSettings": {
                "color": "rgba(0, 0 ,0 ,0.5)",
                "rollOverColor": "#000",
                "selectedColor": "#fff"
            },
            "linesSettings": {
                "arc": -0.7,
                "arrow": "middle",
                "color": "#fff",
                "alpha": 0.8,
                "arrowAlpha": 0,
                "arrowSize": 0
            },
            "zoomControl": {
                "zoomControlEnabled": false,
                "homeButtonEnabled": false
            },
            "zoomOnDoubleClick": false,
            "dragMap": false,
            "linesAboveImages": true,
            "export": {
                "enabled": false
            }
        });
    </script>
@endsection