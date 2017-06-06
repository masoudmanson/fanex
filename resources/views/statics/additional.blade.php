@extends('layouts.master')

@section('header')
    @include('partials.nav', ["type"=>"dark"])
@endsection

@section('content')
    <div class="container-fluid additional-wrapper">
        <div class="row m-0 p-0">
            <div class="col-md-8 col-sm-10 col-xs-12 col-md-push-2 col-sm-push-1 white-div">

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

                    <h1 class="pb-3 mt-0">Complete you account info</h1>

                    <form action="/payment" method="get">
                        {{ csrf_field() }}

                        {{-- Nickname --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-user bsIcon"></i>
                                    <input type="text" class="form-control fanexInput" id="exAmount"
                                           name="amount" placeholder="Choose a Username" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Mobile Number --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-mobile bsIcon"></i>
                                    <input type="text" class="form-control fanexInput numberTextField" id="exAmount"
                                           name="amount" placeholder="Enter Your Mobile Number" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        {{-- Account Number --}}
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group bsWrapper">
                                    <i class="icon-card bsIcon"></i>
                                    <input type="text" class="form-control fanexInput numberTextField" id="exAmount"
                                           name="amount" placeholder="Enter Your Account Number" autocomplete="off">
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
                                <input type="submit" class="btn fanexBtnOutlineGrey" value="Continue" name="payment"/>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>



    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-8 col-md-offset-2">--}}
    {{--<div class="panel panel-default">--}}
    {{--<div class="panel-body">--}}
    {{--<form class="form-group" action="/additional-info" method="post">--}}
    {{--{{ csrf_field() }}--}}

    {{--<div class="form-group">--}}
    {{--<label for="nickname">Nick Name</label>--}}
    {{--<input name="nickname" type="text" class="form-control" id="nickname"--}}
    {{--placeholder="Enter nickname">--}}
    {{--<input type="text" value="{{$state}}" class="form-control" id="state" style="display: none">--}}
    {{--<input type = "text" name="token" value="{{$token}}" class = "form-control" id = "token" style="display: none">--}}

    {{--</div>--}}

    {{--<div class="form-group">--}}
    {{--<label for="account_number">Account Number</label>--}}
    {{--<input name="account_number" type="text" class="form-control" id="account"--}}
    {{--placeholder="Enter account number">--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
    {{--<label for="mobile">Mobile</label>--}}
    {{--<input name="mobile" type="text" class="form-control" id="mobile" placeholder="mobile">--}}
    {{--</div>--}}


    {{--<button type="submit" class="btn btn-default">Submit</button>--}}

    {{--</form>--}}

    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection

@section('footer')
    @include('partials.footer', ["type"=>'dark'])
@endsection

@section('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
@endsection

