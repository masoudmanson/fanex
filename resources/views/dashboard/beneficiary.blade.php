@extends('layouts.master')

@section('styles')

@endsection

@section('header')
    @include('partials.nav', ['type' => 'dashboard'])
@endsection

@section('content')
    <div class="container-fluid dashboard-wrapper">
        <div class="row m-0">
            <h1 class="dash-title"><b>@lang('payment.bnfTitle')</b></h1>
            <div class="col-lg-9 col-md-8 col-sm-12 p-0 bnf-auto-content">
                <div class="row p-0 m-0" id="bnf-slc-container">
                    {{-- Select From Existing Beneficiaries --}}
                    <div class="col-md-6 col-sm-12 p-0 pr-lg-3">
                        <h2 class="dash-subtitle">@lang('payment.bnfSelect')</h2>

                        {{-- Select Beneficiary Box --}}
                        <form action="/proforma" method="get" id="select-bnf-form">
                            {{ csrf_field() }}

                            {{-- Existing Beneficiaries --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="bnf"
                                        id="bnfSelect">
                                    <option selected disabled>@lang('payment.bnfSelect')</option>
                                    @foreach($beneficiaries as $bnf)
                                        <option value="{{ $bnf['id'] }}">{{ $bnf['firstname']. ' ' .$bnf['lastname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <div id="bnf-ajax-div" style="display: none;">
                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-name">
                                    Beneficiary Name
                                </div>
                            </div>

                            {{-- Account Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-card bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-accountnumber">
                                    Account Number
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-globe bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-address">
                                    Beneficiary Address
                                </div>
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-mobile bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-phone">
                                    Mobile
                                </div>
                            </div>

                            {{-- Fax Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-fax bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-fax">
                                    Fax Number
                                </div>
                            </div>

                            {{-- Bank Name --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-bank bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-bankname">
                                    Bank Name
                                </div>
                            </div>

                            {{-- Branch Address --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-branch bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-branch">
                                    Branch Address
                                </div>
                            </div>

                            {{-- Swift Code --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-swift bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-swift">
                                    Swift Code
                                </div>
                            </div>

                            {{-- iBan Number --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-code bsIcon"></i>
                                <div class="form-control fanexInput fanexInputWhite" id="bnf-ajax-iban">
                                    iBan Number
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Create a New Benificiary --}}
                    <div class="col-md-6 col-sm-12 p-0 pl-lg-3 pb-md-3">
                        <h2 class="dash-subtitle">@lang('payment.bnfNew')</h2>

                        {{-- Add Beneficiary Form --}}
                        <form action="#" method="get" id="add-bnf-form">
                            {{ csrf_field() }}

                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-firstname"
                                       name="firstname" placeholder="@lang('payment.bnfFirstname')" autocomplete="off">
                            </div>

                            <div id="add-new-bnf-ajax" style="display: none">
                                {{-- Lastname --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-user bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-lastname"
                                           name="lastname" placeholder="@lang('payment.bnfLastname')" autocomplete="off">
                                </div>

                                {{-- Account Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-card bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                           id="bnf-accountnumber"
                                           name="accountnumber" placeholder="@lang('payment.bnfCC')" autocomplete="off">
                                </div>

                                {{-- Address --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-globe bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-address"
                                           name="address" placeholder="@lang('payment.bnfAddr')" autocomplete="off">
                                </div>

                                {{-- Phone Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-mobile bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                           id="bnf-phone"
                                           name="phone" placeholder="@lang('payment.bnfPhone')" autocomplete="off">
                                </div>

                                {{-- Fax Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-fax bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                           id="bnf-fax"
                                           name="fax" placeholder="@lang('payment.bnfFax')" autocomplete="off">
                                </div>

                                {{-- Bank Name --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-bank bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-bankname"
                                           name="bankname" placeholder="@lang('payment.bnfBank')" autocomplete="off">
                                </div>

                                {{-- Branch Address --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-branch bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite" id="bnf-branch"
                                           name="branch" placeholder="@lang('payment.bnfBranch')" autocomplete="off">
                                </div>

                                {{-- Swift Code --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-swift bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                           id="bnf-swift"
                                           name="swift" placeholder="@lang('payment.bnfSwift')" autocomplete="off">
                                </div>

                                {{-- iBan Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-code bsIcon"></i>
                                    <input type="text" class="form-control fanexInput fanexInputWhite numberTextField"
                                           id="bnf-iban"
                                           name="iban" placeholder="@lang('payment.bnfIban')" autocomplete="off">
                                </div>
                            </div>
                            {{-- Form Submition --}}
                            {{--<input type="button" class="btn fanexBtnOutlineGrey" id="backBtn" value="Back" name="save"/>--}}
                        </form>

                    </div>

                </div>

                {{-- Form Actions --}}
                <div class="row p-0 m-0">
                    <div class="col-sm-6 col-xs-12 p-0 pb-md-0 pb-sm-4 pb-xs-4 pr-md-2 pr-lg-3">
                        <a href="/" class="btn fanexBtnNoline">@lang('payment.backHome')</a>
                    </div>
                    <div class="col-sm-6 col-xs-12 p-0 pl-md-2 pb-md-0 pb-sm-4 pb-xs-4  pl-lg-3">
                        {{--<input type="submit" class="btn fanexBtnOutlineGrey" id="paymentBtn"--}}
                        {{--value="Show Proforma"/>--}}
                        {{--<a href="/proforma" class="btn fanexBtnOutlineGrey">@lang('payment.showProforma')</a>--}}
                        <a onclick="sendBnf()" class="btn fanexBtnOutlineGrey">@lang('payment.showProforma')</a>
                    </div>
                </div>
            </div>

            {{-- SideBar --}}
            @include('partials.stepsSidebar', ['step' => 3])
        </div>
    </div>
@endsection

@section('footer')
    @include('partials.footer', ['type' => 'dashboard'])
@endsection

@section('scripts')
    <script>
        var beneficiaries = {!! $beneficiaries !!};

        $(document).ready(function () {
            $('#bnfSelect').on('change blur', function () {
                $('#add-bnf-form').css({"opacity": 0.5});
                $('#add-new-bnf-ajax').slideUp(200);

                var bnf_id = $(this).val();
                var bnf = beneficiaries[bnf_id - 1];
                $('#bnf-ajax-name').text(bnf.firstname + ' ' + bnf.lastname);
                $('#bnf-ajax-accountnumber').text(bnf.account_number);
                $('#bnf-ajax-address').text(bnf.address);
                $('#bnf-ajax-phone').text(bnf.tel);
                $('#bnf-ajax-fax').text(bnf.fax);
                $('#bnf-ajax-bankname').text(bnf.bank_name);
                $('#bnf-ajax-branch').text(bnf.branch_address);
                $('#bnf-ajax-swift').text(bnf.swift_code);
                $('#bnf-ajax-iban').text(bnf.iban_code);

                $('#bnf-ajax-div').slideDown(300);
            });

            $('#add-bnf-form input').on('focus', function () {
                $('#add-bnf-form').css({"opacity": 1});
                $('#add-new-bnf-ajax').slideDown(200);
                $('#bnf-ajax-div').slideUp(300);
            });

            function sendBnf() {
                var bnf = $('#bnfSelect').val('');
                console.log(bnf);
//                var captcha = $('.captcha-img');
//                var config = captcha.data('refresh-config');
//                $.ajax({
//                    method: 'GET',
//                    url: '/get_captcha/' + config,
//                }).done(function (response) {
//                    captcha.prop('src', response);
//                });
            }

        });
    </script>
@endsection