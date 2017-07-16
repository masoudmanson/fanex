@extends('layouts.master')

@section('styles')
    <style>
        #wrapper{
            font-family: tahoma !important;
            width:300px;
            height:200px;
            background-color:#444;
            color: #fff;
            padding:50px;
            margin:50px;
            text-align: right !important;
            letter-spacing: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div id="wrapper">
        <span style="text-align: right;">این کاراکتر ها بهم میریزند</span>
        <p>Test English Text</p>
        <p>اَلعَرَبیه تِکست</p>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            html2canvas($("#wrapper"), {
                letterRendering: false,
                onrendered: function(canvas) {
                    theCanvas = canvas;

                    document.body.appendChild(canvas);
                }
            });
        });
    </script>
@endsection