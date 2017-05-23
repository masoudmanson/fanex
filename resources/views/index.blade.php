@extends('layouts.master')

@section('styles')
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldHigh.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/amcharts.css') }}" type="text/css" media="all"/>
@endsection

@section('content')
    @include('partials.nav')
    <div class="container-fluid  p-0 indexWrapper">
        <div class="row m-0">
            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexLeft">
                <div class="mainForm">
                    <h1 class="pb-3">International Money E-Transfer</h1>

                    <form action="/calculate" method="post">
                        {{ csrf_field() }}

                        {{-- Destination Country --}}
                        <div class="form-group bsWrapper">
                            <i class="icon-globe bsIcon"></i>
                            <select class="form-control selectpicker" name="country">
                                <optgroup label="Active">
                                    <option value="Turkey">Turkey</option>
                                </optgroup>
                                <optgroup label="Inactive">
                                    <option value="France" disabled>France</option>
                                    <option value="Italy" disabled>Italy</option>
                                    <option value="Germany" disabled>Germany</option>
                                    <option value="Switzerland" disabled>Switzerland</option>
                                    <option value="Sweden" disabled>Sweden</option>
                                    <option value="Norway" disabled>Norway</option>
                                    <option value="Belgium" disabled>Belgium</option>
                                    <option value="Austria" disabled>Austria</option>
                                    <option value="Finland" disabled>Finland</option>
                                    <option value="Greece" disabled>Greece</option>
                                    <option value="Denmark" disabled>Denmark</option>
                                    <option value="Netherlands" disabled>Netherlands</option>
                                    <option value="Portugal" disabled>Portugal</option>
                                    <option value="Spain" disabled>Spain</option>
                                    <option value="England" disabled>England</option>
                                    <option value="Iraq" disabled>Iraq</option>
                                    <option value="Russia" disabled>Russia</option>
                                    <option value="China" disabled>China</option>
                                    <option value="USA" disabled>USA</option>
                                    <option value="Canada" disabled>Canada</option>
                                </optgroup>
                            </select>
                        </div>

                        {{-- Amount + Currency --}}
                        <div class="row">
                            {{-- Amount --}}
                            <div class="col-md-6 col-sm-12 pr-2">
                                <div class="form-group bsWrapper">
                                    <i class="icon-change bsIcon"></i>
                                    <input type="text" class="form-control fanexInput" id="exampleInputAmount"
                                           name="amount" placeholder="Amount">
                                </div>
                            </div>
                            {{-- Currency --}}
                            <div class="col-md-6 col-sm-12 pl-2">
                                <div class="form-group bsWrapper">
                                    <i class="icon-coin bsIcon"></i>
                                    <select class="form-control selectpicker" name="currency">
                                        <option value="lira">Turkish Lira (₺)</option>
                                        <option value="euro">Euro (€)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Captcha --}}
                        <div class="row">
                            {{-- Captcha Image --}}
                            <div class="col-md-6 col-sm-12 pr-2">
                                <div class="form-group bsWrapper">
                                    <a href="/" class="captchaRefresher"><i class="icon-refresh bsIcon"></i></a>
                                    <div class="fanexInput">

                                    </div>
                                </div>
                            </div>
                            {{-- Captcha Input --}}
                            <div class="col-md-6 col-sm-12 pl-2">
                                <div class="form-group bsWrapper">
                                    <i class="icon-check bsIcon"></i>
                                    <input type="text" class="form-control fanexInput" name="captcha"
                                           placeholder="Enter Captcha Here">
                                </div>
                            </div>
                        </div>

                        {{-- Temproray Calculated Amount --}}
                        <div class="tempAmount" style="display: none;">
                            <h2>Cost of Transferring <span>5000 EUR</span> to Turkey is:</h2>
                            <div class="tempAmountWrapper">
                                <span class="calcAmount">15.500.000</span>
                                <span class="tempCurrency">Rials</span>
                            </div>
                        </div>

                        {{-- Form Submition --}}
                        <div class="row">
                            {{-- Calculate Amount --}}
                            <div class="col-md-6 col-sm-12 pr-2">
                                <input type="submit" class="btn fanexBtnOutlineOrange" value="Calculate"
                                       name="calculate"/>
                            </div>
                            {{-- Go For Payment --}}
                            <div class="col-md-6 col-sm-12 pl-2">
                                <input type="submit" class="btn fanexBtnOutlineGrey" value="Pay" name="payment"/>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 p-0 indexWrapperInside indexRight">
                <div id="mapWrapper">

                </div>
                <div class="mottoWrapper">
                    <p class="fanexLogoName">FANEx</p>
                    <p class="fanexMotto">International RELIANCE</p>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker({
                style: 'fanexInput'
            });
        });
        // svg path for target icon
        var targetSVG = "M9,0C4.029,0,0,4.029,0,9s4.029,9,9,9s9-4.029,9-9S13.971,0,9,0z M9,15.93 c-3.83,0-6.93-3.1-6.93-6.93S5.17,2.07,9,2.07s6.93,3.1,6.93,6.93S12.83,15.93,9,15.93 M12.5,9c0,1.933-1.567,3.5-3.5,3.5S5.5,10.933,5.5,9S7.067,5.5,9,5.5 S12.5,7.067,12.5,9z";

        var map = AmCharts.makeChart("mapWrapper", {
            "type": "map",
            "theme": "light",
            "projection": "miller",
            "dataProvider": {
                "map": "worldHigh",
                "zoomLevel": 1,

                "lines": [
                    // Tehran - Ankara, Turkey
//                    {
//                        "latitudes": [35.6892, 39.9334],
//                        "longitudes": [51.3890, 32.8597]
//                    }
                ],
//                               "images": [{
//                    "id": "Tehran",
//                    "svgPath": targetSVG,
//                    "title": "Tehran",
//                    "latitude": 35.6892,
//                    "longitude": 51.3890,
//                    "scale": 0.5,
//                    "showAsSelected": true
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Ankara",
//                    "latitude": 39.9334,
//                    "longitude": 32.8597,
//                    "scale": .5,
//                    "showAsSelected": true
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Washington",
//                    "latitude": 38.9072,
//                    "longitude": -77.0369,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Brussels",
//                    "latitude": 50.8371,
//                    "longitude": 4.3676,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Athens",
//                    "latitude": 37.9792,
//                    "longitude": 23.7166,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Oslo",
//                    "latitude": 59.9138,
//                    "longitude": 10.7387,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Lisbon",
//                    "latitude": 38.7072,
//                    "longitude": -9.1355,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Moscow",
//                    "latitude": 55.7558,
//                    "longitude": 37.6176,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Madrid",
//                    "latitude": 40.4167,
//                    "longitude": -3.7033,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Stockholm",
//                    "latitude": 59.3328,
//                    "longitude": 18.0645,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Bern",
//                    "latitude": 46.9480,
//                    "longitude": 7.4481,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Paris",
//                    "latitude": 48.8567,
//                    "longitude": 2.3510,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Rome",
//                    "latitude": 41.9028,
//                    "longitude": 12.4964,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Berlin",
//                    "latitude": 52.5200,
//                    "longitude": 13.4050,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Vienna",
//                    "latitude": 48.2082,
//                    "longitude": 16.3738,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Helsinki",
//                    "latitude": 60.1699,
//                    "longitude": 24.9384,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Copenhagen",
//                    "latitude": 55.676098,
//                    "longitude": 12.568337,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Amsterdam",
//                    "latitude": 52.3702,
//                    "longitude": 4.8952,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Baghdad",
//                    "latitude": 33.3128,
//                    "longitude": 44.3615,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Beijing",
//                    "latitude": 39.9042,
//                    "longitude": 116.4074,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Ottawa",
//                    "latitude": 45.4215,
//                    "longitude": -75.6972,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Yerevan",
//                    "latitude": 40.1792,
//                    "longitude": 44.4991,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Baku",
//                    "latitude": 40.4093,
//                    "longitude": 49.8671,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Riyadh",
//                    "latitude": 24.7136,
//                    "longitude": 46.6753,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Damascus",
//                    "latitude": 33.5138,
//                    "longitude": 36.2765,
//                    "scale": 0.5
//                }, {
//                    "svgPath": targetSVG,
//                    "title": "Dubai",
//                    "latitude": 25.2048,
//                    "longitude": 55.2708,
//                    "scale": 0.5
//                }],

                "areas": [{
                    "title": "IRAN",
                    "id": "IR",
                    "showAsSelected": true
                }, {
                    "title": "TURKEY",
                    "id": "TR",
                    "showAsSelected": true
                }],
            },

            "areasSettings": {
                "unlistedAreasColor": "rgba(0, 0, 0, 0.08)",
                "unlistedAreasAlpha": 1,
                "unlistedAreasOutlineAlpha": 0,
                "selectedColor": "#000",
                "outlineAlpha": "0",
                "alpha": 0.3
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
            "backgroundZoomsToTop": true,
            "linesAboveImages": true,
            "export": {
                "enabled": false
            }
        });
    </script>
@endsection