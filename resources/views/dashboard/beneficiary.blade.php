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
                        <form action="proforma/selected" method="POST" id="select-bnf-form">
                            {{ csrf_field() }}

                            {{-- Existing Beneficiaries --}}
                            <div class="form-group bsWrapper mim">
                                <i class="icon-user bsIcon"></i>
                                <select class="form-control fanexInput selectpicker"
                                        data-style="fanexInput fanexInputWhite"
                                        name="bnf"
                                        id="bnfSelect">
                                    <option selected disabled value="0">@lang('payment.bnfSelect')</option>
                                    @foreach($beneficiaries as $bnf)
                                        <option value="{{ $bnf['id'] }}"
                                                class="enable">{{ $bnf['firstname']. ' ' .$bnf['lastname'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Show Beneficiary information --}}
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

                            {{-- Submit the form --}}
                            <div class="col-xs-12 p-0">
                                <input type="hidden" name="hash" value="" id="bnfSelectHash">
                                <input type="submit" id="bnfSelectSubmit" class="btn fanexBtnOutlineGrey"
                                       value="@lang('payment.showProformaSelect')" style="display: none;"/>
                            </div>
                        </form>
                    </div>

                    {{-- Create a New Benificiary --}}
                    <div class="col-md-6 col-sm-12 p-0 pl-lg-3">
                        <h2 class="dash-subtitle">@lang('payment.bnfNew')</h2>

                        {{-- Add Beneficiary Form --}}
                        <form action="proforma" method="post" id="add-bnf-form">
                            {{ csrf_field() }}

                            {{-- Firstname --}}
                            <div class="form-group bsWrapper">
                                <i class="icon-user bsIcon"></i>
                                <input type="text"
                                       class="form-control fanexInput @if($errors->first('firstname')) fanexInputError @else fanexInputWhite @endif"
                                       id="bnf-firstname"
                                       name="firstname" placeholder="@lang('payment.bnfFirstname')" autocomplete="off"
                                       value="{{ old('firstname') }}">

                                @if($errors->first('firstname'))
                                    <div class="fanexDanger">{{ $errors->first('firstname') }}</div>
                                @endif
                            </div>

                            <div id="add-new-bnf-ajax">

                                {{-- Lastname --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-user bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('lastname')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-lastname"
                                           name="lastname" placeholder="@lang('payment.bnfLastname')"
                                           autocomplete="off" value="{{ old('lastname') }}">
                                    @if($errors->first('lastname'))
                                        <div class="fanexDanger">{{ $errors->first('lastname') }}</div>
                                    @endif
                                </div>

                                {{-- Account Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-card bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('account_number')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-accountnumber"
                                           name="account_number" placeholder="@lang('payment.bnfCC')" autocomplete="off"
                                           value="{{ old('account_number') }}">

                                    @if($errors->first('account_number'))
                                        <div class="fanexDanger">{{ $errors->first('account_number') }}</div>
                                    @endif
                                </div>

                                {{-- Address --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-globe bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('address')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-address"
                                           name="address" placeholder="@lang('payment.bnfAddr')" autocomplete="off"
                                           value="{{ old('address') }}">

                                    @if($errors->first('address'))
                                        <div class="fanexDanger">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>

                                {{-- Phone Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-mobile bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('tel')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-phone"
                                           name="tel" placeholder="@lang('payment.bnfPhone')" autocomplete="off"
                                           value="{{ old('tel') }}">

                                    @if($errors->first('tel'))
                                        <div class="fanexDanger">{{ $errors->first('tel') }}</div>
                                    @endif
                                </div>

                                {{-- Fax Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-fax bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('fax')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-fax"
                                           name="fax" placeholder="@lang('payment.bnfFax')" autocomplete="off"
                                           value="{{ old('fax') }}">

                                    @if($errors->first('fax'))
                                        <div class="fanexDanger">{{ $errors->first('fax') }}</div>
                                    @endif
                                </div>

                                {{-- Bank Name --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-bank bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('bank_name')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-bankname"
                                           name="bank_name" placeholder="@lang('payment.bnfBank')" autocomplete="off"
                                           value="{{ old('bank_name') }}">

                                    @if($errors->first('bank_name'))
                                        <div class="fanexDanger">{{ $errors->first('bank_name') }}</div>
                                    @endif
                                </div>

                                {{-- Branch Address --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-branch bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('branch_name')) fanexInputError @else fanexInputWhite @endif"
                                           id="bnf-branch"
                                           name="branch_name" placeholder="@lang('payment.bnfBranch')"
                                           autocomplete="off" value="{{ old('branch_name') }}">

                                    @if($errors->first('branch_name'))
                                        <div class="fanexDanger">{{ $errors->first('branch_name') }}</div>
                                    @endif
                                </div>

                                {{-- Swift Code --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-swift bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('swift_code')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-swift"
                                           name="swift_code" placeholder="@lang('payment.bnfSwift')" autocomplete="off"
                                           value="{{ old('swift_code') }}">

                                    @if($errors->first('swift_code'))
                                        <div class="fanexDanger">{{ $errors->first('swift_code') }}</div>
                                    @endif
                                </div>

                                {{-- iBan Number --}}
                                <div class="form-group bsWrapper">
                                    <i class="icon-code bsIcon"></i>
                                    <input type="text"
                                           class="form-control fanexInput  @if($errors->first('iban_code')) fanexInputError @else fanexInputWhite @endif numberTextField"
                                           id="bnf-iban"
                                           name="iban_code" placeholder="@lang('payment.bnfIban')" autocomplete="off"
                                           value="{{ old('iban_code') }}">

                                    @if($errors->first('iban_code'))
                                        <div class="fanexDanger">{{ $errors->first('iban_code') }}</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Form Submition --}}
                            <div class="col-xs-12 p-0 sb-4">
                                <input type="submit" id="bnfSaveSubmit" class="btn fanexBtnOutlineGrey"
                                       value="@lang('payment.showProformaSave')" style="display: none;"/>
                            </div>
                        </form>
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
                $('#bnfSaveSubmit').fadeOut(200);
                $('#bnfSelectSubmit').fadeIn(200);
                $('#add-bnf-form').css({"opacity": 0.5});
                $('#add-new-bnf-ajax').slideUp(200);

                var bnf_id = $(this).val();
                var bnf = beneficiaries[bnf_id - 1];
                $('#bnfSelectHash').val(bnf.hash);

                $('#bnf-ajax-name').text(bnf.firstname + ' ' + bnf.lastname);
                $('#bnf-ajax-accountnumber').text(bnf.account_number);
                $('#bnf-ajax-address').text(bnf.address);
                $('#bnf-ajax-phone').text(bnf.tel);
                $('#bnf-ajax-fax').text(bnf.fax);
                $('#bnf-ajax-bankname').text(bnf.bank_name);
                $('#bnf-ajax-branch').text(bnf.branch_name);
                $('#bnf-ajax-swift').text(bnf.swift_code);
                $('#bnf-ajax-iban').text(bnf.iban_code);

                $('#bnf-ajax-div').slideDown(300);
            });

            $('#add-bnf-form input').on('focus', function () {
                $('#bnfSelect').val(0);
                $('.selectpicker').selectpicker('refresh');
                $('#add-bnf-form').css({"opacity": 1});
                $('#add-new-bnf-ajax').slideDown(200);
                $('#bnf-ajax-div').slideUp(300);
                $('#bnfSaveSubmit').fadeIn(200);
                $('#bnfSelectSubmit').fadeOut(200);
            });
        });
    </script>
@endsection