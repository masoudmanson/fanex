<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    {{-- SEO & Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SSO Header --}}
    {{--<meta name="sso_token" content="{{ Request::bearerToken('authorization') }}">--}}
    {{--<meta name="sso_token" content="{{ csrf_token() }}">--}}

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FanEx') }}</title>

    {{-- General Styles --}}
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">

    {{-- Yielding Page Styles --}}
    @yield('styles')

</head>

<body>

{{-- Yielding Page Content --}}
@yield('header')

{{-- Yielding Page Content --}}
@yield('content')

{{-- Yielding Page Content --}}
@yield('footer')

{{-- General Scripts --}}
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/scripts.js') }}"></script>
<script src="{{ asset('js/accounting.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/jquery.sticky-kit.min.js') }}"></script>
<script src="{{ asset('js/jquery.countdown.min.js') }}"></script>

<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
</script>

{{-- Yielding Pages Scripts --}}
@yield('scripts')

@if(config('app.env') == 'local')
    <script src="http://localhost:35729/livereload.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endif
</body>
</html>
