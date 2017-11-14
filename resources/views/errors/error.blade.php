@extends('layouts.master')

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="error-page">
            <h2 class="error-heading">@if($status == 1000) <b>:\</b> @else {{ $status }} @endif</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i>
                    @if(Lang::has('errors.'.$status.'Title'))
                        @lang('errors.'.$status.'Title')
                    @else
                        @lang('errors.errorTitle')
                    @endif
                </h3>
                <p>
                    @if(Lang::has('errors.'.$status.'Text'))
                        @lang('errors.'.$status.'Text')
                    @else
                        @lang('errors.errorText')
                    @endif
                </p>
            </div>
        </div>

        <div id="t" class="offline">
            <div id="main-frame-error" class="interstitial-wrapper">
                <div id="main-content">
                    <div class="icon icon-offline" alt=""></div>
                </div>
                <div id="offline-resources">
                    <img id="offline-resources-1x"
                         src="{{ asset('css/images/t-rex/default_100_percent/100-offline-sprite.png') }}">
                    <img id="offline-resources-2x"
                         src="{{ asset('css/images/t-rex/default_200_percent/200-offline-sprite.png') }}">
                    <template id="audio-resources"></template>
                </div>
            </div>
        </div>

        <div class="error-desc">
            <p class="error-play">@lang('errors.playText')</p>
            <br>
            <a href="{{ route('index') }}" class="error-back btn fanexBtnOutlineOrange">@lang('errors.backText')</a>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/t-rex.js') }}"></script>
@endsection