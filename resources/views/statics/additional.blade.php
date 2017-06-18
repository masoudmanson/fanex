@extends('layouts.master')

@section('styles')
    <style>
        body {
            background: #f4f4f4 url({{ asset('css/images/pattern.png') }});
            background-size: 30%;
        }
        .navbar-right {
            display: none;
        }
    </style>
@endsection

@section('header')
    @include('partials.nav', ["type"=>"dark"])
@endsection

@section('content')
    <div class="container-fluid additional-wrapper">
        <div class="row m-0 p-0">
            <div class="col-lg-6 col-md-8 col-sm-10 col-xs-12 col-lg-push-3 col-md-push-2 col-sm-push-1 white-div">

                <div class="mainForm">
                    {{-- Form Loading Container --}}
                    <div id="mainFormLoader" style="display:none;">
                        <div class="errors" style="display: none"></div>
                        <div class="spinner2">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>
                    </div>

                    <h1 class="pb-3 mt-0">@lang('index.additionalTitle')</h1>

                    <form action="/additional-info" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name="state" value="{{$state}}" id="state" style="display: none">

                        {{-- Nickname --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-user bsIcon"></i>
                                    <input type="text" class="form-control fanexInput" id="nickname"
                                           name="nickname" placeholder="@lang('index.additionalUsername')" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Number --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-mobile bsIcon"></i>
                                    <input type="text" class="form-control fanexInput numberTextField" id="mobile"
                                           name="mobile" placeholder="@lang('index.additionalMobile')" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-card bsIcon"></i>
                                    <input type="text" class="form-control fanexInput numberTextField" id="account"
                                           name="account_number" placeholder="@lang('index.additionalCC')" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Form Submition --}}
                        <div class="row">
                            {{-- Calculate Amount --}}
                            <div class="col-sm-6 col-xs-12 pr-md-2 mb-xs-4">
                            </div>
                            {{-- Go For Payment --}}
                            <div class="col-sm-6 col-xs-12 pl-md-2">
                                <input type="hidden" value="{{ $state }}" name="state">
                                <input type="submit" class="btn fanexBtnOutlineGrey" value="@lang('index.continue')" name="payment"/>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ["type"=>'dark'])
@endsection

@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

