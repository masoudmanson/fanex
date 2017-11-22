<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    {{-- SEO & Meta Tags --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FanEx') }}</title>

    <link rel="shortcut icon" href="{{ asset('css/images/favicon.png') }}"/>

    {{-- General Styles --}}
    @if(\Illuminate\Support\Facades\App::isLocale('fa'))
        <link href="{{ asset('css/fa.css') }}" rel="stylesheet">
    @else
        <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    @endif

    {{-- Yielding Page Styles --}}
    @yield('styles')
</head>

<body class="m-0 p-0" id="main-body">
    {{-- Yielding Page Content --}}
    @yield('header')

    {{-- Yielding Page Content --}}
    @yield('content')

    {{-- Yielding Page Content --}}
    @yield('footer')

    {{-- General Scripts --}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/scripts.js') }}"></script>
    <script src="{{ asset('js/classie.js') }}"></script>
    <script>
      var csrfToken = $('meta[name="csrf-token"]').attr('content');
      var timeOut = "@lang('index.timeout')";
      var indexFormCountry = "@lang('js.indexFormCountry')";
      var indexFormCurrency = "@lang('js.indexFormCurrency')";
      var indexFormAmount = "@lang('js.indexFormAmount')";
      var indexFormCaptcha = "@lang('js.indexFormCaptcha')";
      var indexFormCalculate = "@lang('js.indexFormCalculate')";
      var indexFormPay = "@lang('js.indexFormPay')";
      var statuses = {
          'successful' : '@lang('profile.successful')',
          'pending' : '@lang('profile.pending')',
          'waiting' : '@lang('profile.waiting')',
          'failed' : '@lang('profile.failed')',
          'rejected' : '@lang('profile.rejected')',
          'canceled' : '@lang('profile.canceled')',
          'accepted' : '@lang('profile.accepted')'
      };

      var AMOUNT_LIMIT_MIN = 0;
      $.ajaxSetup(
          {
            headers: {
              'X-CSRF-Token': csrfToken,
              '_token': csrfToken,
            },
          });
    </script>

    {{-- Yielding Pages Scripts --}}
    @yield('scripts')
</body>
</html>
